<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Language;
use App\Models\Link;
use App\Models\Product;
use App\Models\Subcategory;
use DiDom\Document;
use DiDom\Element;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use function Illuminate\Events\queueable;

class TechnoparkParserService extends ParserService
{
    private int $counter = 0;
    public function __construct(private PageService $pageService,string $root)
    {
        Link::query()->updateOrCreate(['url'=>'https://www.techport.ru/spb/katalog/products'],[['url'=>'https://www.techport.ru/spb/katalog/products','parsed'=>1]]);
        parent::__construct($root);
    }

    function saveCookies(string $response)
    {
        // TODO: Implement saveCookies() method.
    }
    public function getContent(Model $model)
    {
        $news = $model::query()->where('parsed','=','false')->get();
        foreach ($news as $item){
            if ($this->counter>=10){
                $this->log('ended parsing session successfully');
                return;
            }
            $this->log("started parsing $item->url");
                $options = ['headers'=>1,'redirects'=>1,'variable'=>1,'cookies'=>1];
                $page = $this->getPage($item->url,$options);
//                file_put_contents('text.txt',$page);
//                die();
            $this->target =$item->url;
//            $page = file_get_contents('text.txt');
            if ($this->mainPageCheck($item->url)){
                $this->getCategories($page,$item);
            } else{
//                echo $page;
//                die();
                if ($this->subcategoriesPageCheck($page)){
                    $this->getSubcategories($page,$item);
                }
                if ($this->productsPageCheck($page)){
                    $this->getProducts($page,$item);
                }
                if ($this->productPageCheck($page)){
                    $this->getProduct($page,$item);
                }
            }

//            проверка на то страница это новости или ссылка на ajax
            $item->update(['parsed'=>1]);
            $this->log("ended parsing $item->url");
            $this->counter++;
            $number = rand(1,5);
            sleep($number);
        }
    }
    private function mainPageCheck(string $url)
    {
        return preg_match('#^https://www.techport.ru/spb/katalog/products$#',$url);
    }
    private function saveCaterogies(array $names)
    {
        foreach ($names as $name){
            $request = new Request(['name'=>$name]);
            $this->pageService->saveCategory($request);
        }
    }
    private function getCategories(string $page,Model $model)
    {
        $patterns = ['a.tcp-directory-item__heading'];
        $document = new Document($page);
        $names = [];
        foreach ($patterns as $pattern){
            $hrefs=$document->find($pattern);
            $links=$this->getLinks($hrefs);
            foreach ($hrefs as $href){
                $names[]=$href->text();
            }
        }
        $this->saveCaterogies($names);
        $this->saveLinks($links, $model);
    }
    private function subcategoriesPageCheck(string $page){
        $document = new Document($page);
        $pattern = 'div.categories-block';
        return $document->first($pattern);
    }
    private function getSubcategories(string $page,Model $model)
    {
        $categoryNamePattern = '.tcp-dashboard-header__h1';
        $patterns = ['.categories-block .tcp-container > a'];
        $document = new Document($page);
        $categoryName=$document->first($categoryNamePattern)->text();
        $subcategoriesNames = [];
        foreach ($patterns as $pattern){
            $hrefs=$document->find($pattern);
            $links=$this->getLinks($hrefs);
            foreach ($hrefs as $href){
                $href=$href->first('img');
                $subcategoriesNames[]=$href->getAttribute('alt');
            }
        }
        $this->saveSubcategories($subcategoriesNames,$categoryName);
        $this->saveLinks($links, $model);
    }
    private function saveSubcategories(array $subcategoriesNames,string $categoryName)
    {
        foreach ($subcategoriesNames as $subcategoryName){
            $request = new Request(['name' => $subcategoryName,'category'=>$categoryName]);
            $this->pageService->saveSubcategory($request);
        }
    }
    private function productsPageCheck(string $page)
    {
        $document = new Document($page);
        $pattern = '.tcp-catalog';
        return $document->first($pattern);
    }
    private function getProducts(string $page,Model $model)
    {
        $document = new Document($page);
        $pattern = '.tcp-catalog a.tcp-product__link';
        $hrefs = $document->find($pattern);
        $links=$this->getLinks($hrefs);
        $this->saveLinks($links,$model);
    }
    private function productPageCheck(string $page)
    {
        $document = new Document($page);
        $pattern = '.tcp-product-tabs';
        return $document->first($pattern);
    }
    private function getProduct(string $page)
    {
        $document = new Document($page);
        $imageCRS = $document->first('.product_image')->getAttribute('src');
        $properties = $this->getProductsProperties($document);
        $name = $this->getProductName($document);
        $price = $this->getPrice($document);
        $hrefs = $document->find('.tcp-breadcrumbs.tcp-breadcrumbs_hidden-xs a');
        $categoryName = $hrefs[0]->text();
        $subcategoryName = $hrefs[1]->text();
        $this->saveProduct($categoryName,$subcategoryName,$price,$name,$properties,$imageCRS);
    }
    private function saveProduct(string $categoryName,string $subcategoryName,string $price,string $name,array $properties,string $imageCRS='')
    {
        $subcategory = $this->pageService->getSubcategoryByName($subcategoryName);
        $properties = array_merge($properties,['category_id'=>$subcategory->category_id,'subcategory_id'=>$subcategory->id,'name'=>$name,'price'=>$price,'quantity'=>'10']);
        $request = new Request($properties);
        $product = $this->pageService->createProduct($request);
        $this->savePhoto($imageCRS,$product);
    }
    private function savePhoto($imageCRS,Product $product)
    {
        $path = "photos/{$product->category->id}/{$product->subcategory->id}/$product->id";
        $fileService = new FileService();
        $fileService->createDir($path);
        $file = file_get_contents('https:'.$imageCRS);
        preg_match('#/[^/]*?$#',$imageCRS,$matches);
        $filename = mb_substr($matches[0],1);
        $product->images()->create([
            'path'=>"$path",
            'name'=>$filename
        ]);
        file_put_contents("$path/$filename",$file);
    }
    private function getPrice(Document $document)
    {
        $price = $document->first('.tcp-product-body__new-price.tcp-product-body-set__new-price')->text();
        return preg_replace('/\D/', '', $price);
    }
    private function getProductName(Document $document)
    {
        return $document->first('.tcp-dashboard-header__h1')->innerHtml();
    }
    private function getProductsProperties(Document $document)
    {
        $properties = [];
        $pattern = '.tcp-specification tr';
        $info = $document->find($pattern);
        foreach ($info as $values){
            $name = trim($values->first('.tcp-specification__name')->innerHtml(),': ');
            if ($name=='Код'){
                continue;
            }
            elseif ($name=='Производитель'){
                $value = $values->first('.tcp-specification__value a')->innerHtml();
            } else{
                $value = $values->first('.tcp-specification__value .tcp-specification__content')->innerHtml();
            }
            $properties[$name] = $value;
        }
        return $properties;
    }
}
