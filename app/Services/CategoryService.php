<?php

namespace App\Services;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CategoryService
{
    public function save(Request $request,Language $language)
    {
        $validated = $request->validate(['name'=>['required']]);
        $category = $language->categories()->where('name',$validated['name'])->first();
        if (!$category){
            $category = Category::query()->create();
            $language->categories()->attach($category,$validated);
        }
        return $validated;
    }
    public function update(Request $request, Category $category,Language $language)
    {
        $validated = $request->validate(['name'=>['required']]);
        $pivot = $this->getPivot($category,$language);
        if ($pivot){
            $this->updatePivot($validated,$pivot);
        } else{
            $language->categories()->attach($category,$validated);
        }
        return $category;
    }
    private function getPivot(Category $category,Language $language)
    {
        return $category->languages->firstWhere('id','=',$language->id);
    }
    private function updatePivot(array $validated,Language $pivot)
    {
        $pivot->pivot->update($validated);
    }
}
