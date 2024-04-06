<?php

namespace App\Services;

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
    public function saveProduct(Request $request)
    {
        $productMainProperties = $this->validateProductProperties($request);
        $subcategory = $this->getSubcategory($request);
        $productMainProperties['subcategory_id']=$subcategory->id;
        $productMainProperties['category_id']=$subcategory->category_id;
        $product = Product::query()->create($productMainProperties);
        $this->saveAdditionalProperties($request,$product);
        $this->saveImagesOfProduct($request,$product);
        return $product;
    }
    public function getProductsAdditionalProperties(\Illuminate\Support\Collection $products):array
    {
        $result = [];
        foreach ($products as $product){
            $properties = json_decode($product->additional_properties);
            foreach ($properties as $property => $value){
                $result[$product->subcategory_id][$property][]=$value;
            }
        }
        return $result;
    }
    public function getProductAdditionalProperties(Product $product):array
    {
        return json_decode($product->additional_properties,true);
    }
    public function getFilteredProducts(Request $request):Collection
    {
        $products = Product::query();
        $price = $request->input('price');
        $additionalProperties = $request->except(['subcategory','price']);
        $subcategory_id=$request->input('subcategory');
        if (isset($price)){
            $products=$products->where('price','<',$price);
        }
        if (isset($subcategory_id)){
            $products=$products->where('subcategory_id','=',$subcategory_id);
        }
        $products=$products->get();
        if (isset($additionalProperties)){
            /*
             * Первый цикл проходит по свойствам из запроса, а во вложенном цикле происходит проверка,
             * есть ли значение и равно ли оно значению из запроса, при неправильности значение убирается из коллекции
             */
            $products=$products->filter(function ($product) use ($additionalProperties){
                $properties = json_decode($product->additional_properties);
                foreach ($additionalProperties as $propertyName => $values){
                    foreach ($values as $value){
                        if (!property_exists($properties,$propertyName)){
                            return false;
                        }
                        if ($properties->$propertyName != $value){
                            return false;
                        }
                    }
                }
                return true;
            });
        }
        return $products;
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
    private function saveAdditionalProperties(Request $request,Product $product)
    {
        $json = $this->encodeProductProperties($request);
        if ($json){
            $product->update(['additional_properties'=>$json]);
        }
    }
    private function validateProductProperties(Request $request):array
    {
        return $request->validate([
            'price'=>'required',
            'quantity'=>'required',
            'name'=>'required',
        ]);
    }
    private function encodeProductProperties(Request $request): bool|string
    {
        $properties = $request->except(['price','quantity','type','name','_token','subcategory','images']);
        return json_encode($properties);
    }
    private function getSubcategory(Request $request): object
    {
        $subcategoryName = $request->validate([
            'subcategory'=>'required'
        ]);
        return Subcategory::query()->where('name',$subcategoryName)->first();
    }
    private function saveImagesOfProduct(Request $request,Product $product): void
    {
        $images = $request->file(['images']);
        $path = "photos/{$product->category->name}/{$product->subcategory->name}/$product->id";
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
