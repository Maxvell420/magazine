<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Link;
use DiDom\Document;
use DiDom\Element;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function Illuminate\Events\queueable;

class TechnoparkParserService extends ParserService
{
    private int $counter = 0;
    private $language;
    public function __construct(private PageService $pageService,string $root)
    {
        $this->language=Language::find(2);
        Link::query()->updateOrCreate(['url'=>'https://spb.technopark.ru/'],[['url'=>'https://spb.technopark.ru/','parsed'=>0]]);
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
//            if ($this->counter>=10){
//                $this->log('ended parsing session successfully');
//                return;
//            }
//            $this->log("started parsing $item->url");
//                $options = ['headers'=>1,'redirects'=>1,'variable'=>1,'cookies'=>1];
//                $page = $this->getPage($item->url,$options);
//                file_put_contents('text.txt',$page);
//                die();
            $this->target =$item->url;
            $page = file_get_contents('text.txt');
            echo $page;
            die();
            $this->getCategories($page,$item);
            $subcategories = $this->subcategoryPageCheck($page);
            if ($subcategories){
                $this->parseSubcategories($page,$item);
            }
            dd(1);
//            проверка на то страница это новости или ссылка на ajax
//            $item->update(['parsed'=>1]);
//            $this->log("ended parsing $item->url");
//            $this->counter++;
//            $number = rand(1,5);
//            sleep($number);
        }
    }
    private function parseProduct(string $page)
    {

    }
    private function parseSubcategories(string $page,Model $model)
    {
        $document = new Document($page);
        $subcategoriesDiv=$document->first('.tags-section__grid.tags-section__grid--not-slider');
        $categoryName = trim($document->first('.tp-typography.tp-typography--v-heading-1.tp-typography--w-medium.tp-typography--align-left.tp-heading')->text());
        $subcategories = $subcategoriesDiv->find('.tp-tag');
        foreach ($subcategories as $element){
            $href = $element->getAttribute('href');
            $href=$this->normalize($href);
            $link = $model::query()->firstOrCreate(['url'=>$href],['url'=>$href]);
            if ($link->wasRecentlyCreated){
                $subcategoryName=$element->first('.tp-tag__title')->text();
                $this->saveSubcategory($subcategoryName,$categoryName);
            }
        }
    }
    private function saveSubcategory(string $subcategoryName,string $categoryName)
    {
        $request = new Request(['name' => $subcategoryName,'category'=>$categoryName]);
        $this->pageService->saveSubcategory($request);
    }
    private function subcategoryPageCheck(string $page)
    {
        $document = new Document($page);
        return $document->first('.tags-section__grid.tags-section__grid--not-slider');
    }
    private function getCategories(string $page,Model $model)
    {
        $linksPatterns = ['.catalog-menu__nav-item > a '];
        $categoryNamesPatterns = ['.catalog-menu__nav-link__text'];
        $document = new Document($page);
        $categoriesNames = [];
        foreach ($linksPatterns as $linkPattern){
            $hrefs = $document->find($linkPattern);
        }
        $links = $this->getLinks($hrefs);
        foreach ($categoryNamesPatterns as $categoryNamePattern){
            $nameDivs = $document->find($categoryNamePattern);

            foreach ($nameDivs as $div){
                $categoriesNames[]=trim($div->text());
            }
        }
        $this->saveCategories($categoriesNames);
        $this->saveLinks($links,$model);
    }
    private function saveCategories(array $categoriesNames)
    {
        foreach ($categoriesNames as $categoryName){
            $request = new Request(['name' => $categoryName]);
            $this->pageService->saveCategory($request);
        }
    }
}
