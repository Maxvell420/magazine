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
        $reviews = $product->reviews();
        return view('components.products.reviews',compact(['product','reviews']));
    }
    public function ajaxCharacteristics(int $product_id)
    {
        $product = Product::find($product_id);
        try {
            $this->pageService->getModelProperties($product,'properties');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('main.error',compact(['message']));
        }
        $properties = $product->additional_properties;
        return view('components.products.characteristics',compact(['product','properties']));
    }
}
