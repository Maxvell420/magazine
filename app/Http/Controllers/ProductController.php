<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\PageService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController
{
    public function __construct(private ProductService $productService,private PageService $pageService)
    {}
    public function create()
    {
        $title = 'Создание категорий, подкатегорий и их продуктов';
        $pageService = $this->pageService;
        $categoryNames = $pageService->getCategoriesJson(['name','id']);
        $subcategoryNames = $pageService->getSubcategoriesJson(['name','id']);
        $styles = 'css/productCreate.css';
        return view('product.create',compact(['styles','categoryNames','subcategoryNames','title']));
    }
    public function save(Request $request)
    {
        $product = $this->productService->saveProduct($request);
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
        return redirect()->route('main.product',$product);
    }
}
