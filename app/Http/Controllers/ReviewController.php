<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function save(Request $request,Product $product){
        dd(1);
    }
}
