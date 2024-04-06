<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
    public function __construct(protected PageService $pageService)
    {
    }
    public function cart()
    {
        $products = $this->pageService->getProductsFromCart();
        $scripts = 'scripts/cart.js';
        $styles = 'css/main/cart.css';
        $title = 'Ваша корзина';
        return view('main.cart',compact(['products','styles','scripts','title']));
    }
    public function dashboard(Request $request)
    {
        $title = 'Медуса - интернет магазин самых разных вещей!';
        $scripts = 'scripts/dashboard.js';
        $styles = 'css/main/dashboard.css';
        $pageService = $this->pageService;
        $categories = $pageService->getCategoriesJson(['name','id']);
        $subcategories = $pageService->getSubcategoriesJson(['name','category_id','id']);
        $productsProperties = json_encode($pageService->getProductsProperties());
        $products = $pageService->getFilteredProducts($request);
        $favourites = $this->pageService->getUserFavourites();
        return view('main.dashboard',compact(['categories','subcategories','products','productsProperties','styles','scripts','favourites','title']));
    }
    public function favourites()
    {
        $title = 'Ваши избранные товары';
        $user = Auth::user();
        $products = $user->products()->get();
        $this->pageService->loadProductsData($products);
        $favourites = $products->pluck('id')->toArray();
        $styles = 'css/main/favourites.css';
        $scripts = 'scripts/favourites.js';
        return view('main.favourites',compact(['products','favourites','styles','scripts','title']));
    }
    public function productShow(Product $product)
    {
        $title = "Продукт: {$product->name}";
        $properties = $this->pageService->getProductProperties($product);
        $favourites = $this->pageService->getUserFavourites();
        $product->loadExternalData();
        $styles = 'css/main/product.css';
        $scripts = 'scripts/product.js';
        return view('main.product',compact(['properties','styles','product','favourites','scripts','title']));
    }
    public function checkout(Request $request)
    {
        $title = "Подтверждение заказа";
        try {
            $products = $this->pageService->getOrderedProductsFromRequest($request);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('error',compact(['message']));
        }
        $scripts = 'scripts/checkout.js';
        $deliveries = Delivery::all();
        $totalPrice = $this->pageService->getProductsPrice($products);
        $styles = 'css/main/checkout.css';
        return view('main.checkout',compact(['products','styles','deliveries','totalPrice','scripts','title']));
    }
    public function orderShow(Order $order)
    {
        $title = "Заказ№-{$order->id}";
        try {
            $products = $this->pageService->getOrderedProducts($order);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('error',compact(['message']));
        }
        $styles = 'css/main/order.css';
        $filepath=$order->filepath.$order->filename;
        $delivery = $order->delivery;
        $orderQuantity = $this->pageService->getOrderQuantity($order,$products);
        return view('main.order',compact(['products','order','filepath','delivery','orderQuantity','styles','title']));
    }
    public function adminBoard(Request $request)
    {
        $styles = 'css/main/adminka.css';
        $scripts = 'scripts/adminka.js';
        $title = 'Панель администратора';
        $orders = $this->pageService->getOrders($request);
        $date = date('Y-m-d');
        $newOrders = $orders->filter(function($order) use ($date){
            return $date == $order->created_at->format('Y-m-d');
        });
        $this->pageService->attachHrefToOrder($orders);
        return view('main.adminka',compact(['orders','newOrders','styles','scripts','title']));
    }
    public function orders()
    {
        $title = 'Ваши заказы';
        $user = Auth::user();
        $orders = $this->pageService->getUserOrders($user);
        $styles = 'css/main/orders.css';
        return view('main.orders',compact(['orders','styles','title']));
    }
}
