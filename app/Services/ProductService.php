<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use function Symfony\Component\Translation\t;

class ProductService
{
    public function __construct(private FileService $fileService)
    {
    }
    public function getProducts(?array $products_ids):Collection|null
    {
        $products_ids=$products_ids??[];
        return Product::query()->whereIn('id',$products_ids)->get();
    }
    public function saveProduct(Request $request,Language $language)
    {
        $productMainProperties = $this->validateProductProperties($request);
        $category = $request->input('category_id');
        if (!isset($category)){
            $subcategory = $this->getSubcategory($request);
            $productMainProperties['subcategory_id']=$subcategory->id;
            $productMainProperties['category_id']=$subcategory->category_id;
        } else{
            $productMainProperties['subcategory_id']=$request->input('subcategory_id');
            $productMainProperties['category_id']=$request->input('category_id');
        }
        $product = Product::query()->create($productMainProperties);
        $this->saveAdditionalProperties($request,$language,$product);
        $this->saveImagesOfProduct($request,$product);
        return $product;
    }
    public function getProductsAdditionalProperties(\Illuminate\Support\Collection $products,Language $language):array
    {
        $result = [];
        foreach ($products as $product){
            $properties = json_decode($product->properties);
            foreach ($properties as $property => $value){
                if (isset($result[$product->subcategory_id][$property])){
                    if (in_array($value,$result[$product->subcategory_id][$property])){
                        continue;
                    }
                }
                $result[$product->subcategory_id][$property][]=$value;
            }
        }
        return $result;
    }
    public function getProductAdditionalProperties(Product $product):array
    {
        return json_decode($product->additional_properties,true);
    }
    public function filterMainProperties(Request $request, Language $language):Collection
    {
        $products = $language->products();
        $price = $request->input('price');
        $subcategory_id=$request->input('subcategory');
        if (isset($price)){
            $products=$products->where('price','<',$price);
        }
        if (isset($subcategory_id)){
            $products=$products->where('subcategory_id','=',$subcategory_id);
        }
        return $products->get();
    }
//    собственно пример кода с использованием laravel
//      в данном случае ко мне приходит коллекция продуктов с запросом и метод фильтрует 'дополнительные' свойства каждого продукта' и возвращает что осталось
    public function getFilteredProducts(Request $request, Collection $products):Collection
    {
//        С запроса беру все ключи кроме перечисленных ниже и если это не пустой массив
        $additionalProperties = $request->except(['subcategory','price','products']);
        if ($additionalProperties){
        $products=$products->filter(function ($product) use ($additionalProperties){
//          В базе данных я храню все свойства продукта в виде json (неоднозначным решением оказалось по итогу), декодирую его и проверяю каждый каждый продукт на соответствие
                $properties = json_decode($product->properties);
                foreach ($additionalProperties as $propertyName => $values){
//                    Заменяю нижнии подчеркивания в свойствах продуктов (с надеждой что в самом свойстве продукта нет нижнего подчеркивания)
                    $name = preg_replace('#_#', ' ', $propertyName);
//                    Собственно проверка на наличие у продукта
                    if (!property_exists($properties,$name)){
                        return false;
                    }
//                    и проверка на значение свойства
                    if (!in_array($properties->$name,$values)){
                        return false;
                    }
                }
                return true;
            });
        }
        return $products;
    }
    public function updateProduct(Request $request,Product $product,Language $language):product
    {
        $mainProperties = $this->validateProductProperties($request);
        $this->updatePivotOfProduct($request,$product,$language);
        $product->update($mainProperties);
        return $product;
    }
    private function updatePivotOfProduct(Request $request,Product $product,Language $language)
    {
        $productAdditionalProperties = ['properties'=>$this->encodeProductProperties($request)];
        $pivot = $product->languages->firstWhere('id',$language->id);
        if ($pivot){
            $pivot->pivot->update($productAdditionalProperties);
        } else{
            $language->products()->attach($product->id,$productAdditionalProperties);
        }
        return $product;
    }
    public function loadProductsData(Collection $products): Collection
    {
        $products->map(function ($product){
            $product->loadExternalData();
        });
        return $products;
    }
    public function getProductsTotalPrice(Collection $products):int
    {
        $price = 0;
        foreach ($products as $product){
            $price+=$product->total_price;
        }
        return $price;
    }

    /**
     * @throws \Exception
     */
    public function setProductsCartParams(array $products_request,$products): ?\Illuminate\Support\Collection
    {
        foreach ($products as $product){
            if (array_key_exists($product->id,$products_request)){
                if ($product->quantity < $product->total_quantity) {
                    throw new \Exception('Ошибка: Количество товара в заказе меньше чем доступно на складе');
                }
                $quantity = $products_request[$product->id];
                $product->setAttribute('total_quantity',$quantity);
                $product->setAttribute('total_price',$quantity*$product->price);
            }
        }
        return $products;
    }
    private function saveAdditionalProperties(Request $request,Language $language,Product $product):void
    {
        $json = $this->encodeProductProperties($request);
        if ($json){
            $language->products()->attach($product->id,['properties'=>$json]);
        }
    }
    private function validateProductProperties(Request $request):array
    {
        return $request->validate([
            'price'=>'required',
            'quantity'=>'required',
        ]);
    }
    private function encodeProductProperties(Request $request): bool|string
    {
        $properties = $request->except(['price','quantity','type','_token','subcategory','images','subcategory_id','category_id']);
        return json_encode($properties);
    }
    private function getSubcategory(Request $request): object
    {
        $subcategory_id = $request->validate([
            'subcategory'=>'required'
        ]);
        return Subcategory::find($subcategory_id)->first();
    }
    private function saveImagesOfProduct(Request $request,Product $product): void
    {
        $images = $request->file(['images']);
        $path = "photos/{$product->category->id}/{$product->subcategory->id}/$product->id";
        if (isset($images)){
            foreach ($images as $image){
                $this->fileService->downloadFile($image,$path);
                $product->images()->create([
                    'path'=>"$path",
                    'name'=>$image->getClientOriginalName()
                ]);
            }
        }
    }
}
