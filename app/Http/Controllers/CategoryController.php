<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate(['name'=>['required']]);
        $subcategory = Category::query()->create($validated);
        return redirect()->back()->with('message',"Категория $subcategory->name создана");
    }
}
