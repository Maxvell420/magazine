<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
class SubcategoryController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate(
            ['name'=>['required'],'category'=>'required']);
        $category = Category::query()->where('name',$validated['category'])->first();
        unset($validated['category']);
        $subcategory=$category->subcategory()->create($validated);
        return redirect()->back()->with('message',"Подкатегория $subcategory->name создана");
    }
}
