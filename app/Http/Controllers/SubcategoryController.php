<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SubcategoryController extends Controller
{
    public function save(Request $request)
    {
        $lang = App::getLocale();
        $language = Language::firstWhere('name',$lang);
        $categoryName = $request->validate(
            ['category'=>'required']);
        $category = $language->categories()->wherePivot('name',$categoryName['category'])->first();
        $subcategoryName = $request->validate(
            ['name'=>['required']]);
        $subcategory = Subcategory::create(['category_id'=>$category->id]);
        $language->subcategories()->attach($subcategory->id,['name'=>$subcategoryName['name']]);
        return redirect()->back()->with('message',trans('subcategory.created',['name'=>$subcategoryName['name']]));
    }
}
