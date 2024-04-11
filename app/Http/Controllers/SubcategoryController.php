<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Subcategory;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SubcategoryController extends Controller
{
    public function __construct(private PageService $pageService)
    {
    }
    public function save(Request $request)
    {
        $subcategoryName=$this->pageService->saveSubcategory($request);
        return redirect()->back()->with('message',trans('subcategory.created',['name'=>$subcategoryName['name']]));
    }
    public function update(Request $request,Subcategory $subcategory)
    {
        $this->pageService->updateSubcategory($request,$subcategory);
        return redirect()->back();
    }
}
