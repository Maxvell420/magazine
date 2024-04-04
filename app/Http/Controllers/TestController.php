<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;

class TestController extends Controller
{
    public function test()
    {
        $products = Product::all();
//        $productsInCart = [];
//        if (array_key_exists('cart',$_COOKIE)){
//            $cart = $_COOKIE['cart'];
//            foreach (json_decode($cart)->products as $product_id){
//                $productsInCart[]=$product_id;
//            }
//        }
        return response()->view('public',compact(['products']));
    }
}
