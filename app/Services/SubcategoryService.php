<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryService
{
    public function save(Request $request,Language $language)
    {
        $categoryName = $request->validate(
            ['category'=>'required']);
        $category = $language->categories()->wherePivot('name',$categoryName['category'])->first();
        $subcategoryName = $request->validate(
            ['name'=>['required']]);
        $subcategory = Subcategory::create(['category_id'=>$category->id]);
        $language->subcategories()->attach($subcategory->id,['name'=>$subcategoryName['name']]);
        return $subcategoryName;
    }
    public function update(Request $request, Subcategory $subcategory,Language $language)
    {
        $validated = $request->validate(['name'=>['required']]);
        $pivot = $this->getPivot($subcategory,$language);
        if ($pivot){
            $this->updatePivot($validated,$pivot);
        } else{
            $language->subcategories()->attach($subcategory,$validated);
        }
        return $subcategory;
    }
    private function getPivot(Subcategory $subcategory,Language $language)
    {
        return $subcategory->languages->firstWhere('id','=',$language->id);
    }
    private function updatePivot(array $validated,Language $pivot)
    {
        $pivot->pivot->update($validated);
    }
}
