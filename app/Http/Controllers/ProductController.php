<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\PageService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ProductController
{
    public function __construct(private PageService $pageService)
    {}
    public function save(Request $request)
    {
        $product = $this->pageService->createProduct($request);
        return view('product.show',compact(['product']));
    }
    public function like(Product $product)
    {
        $id = Auth::id();
        $product->users()->attach($id);
        return redirect()->back();
    }
    public function dislike(Product $product)
    {
        $id = Auth::id();
        $product->users()->detach($id);
        return redirect()->back();
    }
    public function update(Request $request,Product $product)
    {
        $lang = App::getLocale();
        $product = $this->pageService->updateProduct($request,$product);
        return redirect()->route($lang.'.'.'product.edit',$product);
    }
    public function ajaxReviews(int $product_id)
    {
        $product = Product::find($product_id);
        $reviews = $product->reviews;
        $reviews->each(function ($item) {
            $item->setTime();
        });
        return view('components.products.reviews',compact(['product','reviews']));
    }
    public function ajaxCharacteristics(int $product_id)
    {
        $product = Product::find($product_id);
        try {
            $this->pageService->getModelProperties($product,'properties');
            $properties = $product->additional_properties;
            if (!$properties){
                throw new \Exception(trans('errors.productShowLang'));
            }
        } catch (\Exception $e) {
            if ($e->getMessage() == 'foreach() argument must be of type array|object, null given'){
                $message = trans('errors.productShowLang');
            } else{
                $message = $e->getMessage();
            }
            return view('components.products.error',compact(['message']));
        }
        $properties = $product->additional_properties;
        return view('components.products.characteristics',compact(['product','properties']));
    }
}
