<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CategoryController extends Controller
{
    public function __construct(private PageService $pageService)
    {
    }

    public function save(Request $request)
    {
        $validated = $this->pageService->saveCategory($request);
        return redirect()->back()->with('message',trans('category.created',['name'=>$validated['name']]));
    }
    public function update(Request $request, Category $category)
    {
        $this->pageService->updateCategory($request,$category);
        return redirect()->back();
    }
}
