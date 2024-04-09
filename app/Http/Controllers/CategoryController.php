<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CategoryController extends Controller
{
    public function save(Request $request)
    {
        $lang = App::getLocale();
        $language = Language::query()->where('name',$lang)->first();
        $validated = $request->validate(['name'=>['required']]);
        $category = Category::query()->create();
        $language->categories()->attach($category,$validated);
        $name = $category->getPropertyFromPivot($language,'name');
        return redirect()->back()->with('message',trans('category.created',['name'=>$name]));
    }
}
