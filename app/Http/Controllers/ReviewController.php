<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function save(Request $request,Product $product){
        $user_id = Auth::id();
        $validated = $request->validate(['text'=>'required']);
        $validated['user_id'] = $user_id;
        $product->reviews()->create($validated);
        return redirect()->back();
    }
}
