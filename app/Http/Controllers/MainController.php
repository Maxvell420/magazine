<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Services\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MainController extends Controller
{
    public function __construct(protected PageService $pageService)
    {
        $url = \request()->path();
        $this->pageService->determineLang($url);
    }
    public function index()
    {
        return redirect()->route('en.main.dashboard');
    }
    public function cart()
    {
        try {
            $products = $this->pageService->getProductsFromCart();
            $this->pageService->getProductsNames($products);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('main.error',compact(['message']));
        }
        $scripts = 'scripts/cart.js';
        $styles = 'css/main/cart.css';
        $title = 'Ваша корзина';
        return view('main.cart',compact(['products','styles','scripts','title']));
    }
    public function productEdit(Product $product)
    {
        $title = "Редактирование продука: {$product->name}";
        $styles ='css/main/productEdit.css';
        $scripts='scripts/productEdit.js';
        try {
            $this->pageService->getModelProperties($product,'properties');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('warning', $message);
        }
        $product->loadExternalData();
        $properties = $product->additional_properties??[];
        return view('main.productEdit',compact(['properties','styles','scripts','title','product']));
    }
    public function dashboard(Request $request)
    {
        $title = 'Медуса - интернет магазин самых разных вещей!';
        $scripts = 'scripts/dashboard.js';
        $styles = 'css/main/dashboard.css';
        $pageService = $this->pageService;
        $subcategories = json_encode($pageService->getSubcategories());
        $categories = json_encode($pageService->getCategories());
        $productsProperties = json_encode($pageService->getProductsProperties());
        $products = $pageService->getFilteredProducts($request);
        $this->pageService->getProductsNames($products);
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
        try {
            $this->pageService->getModelProperties($product,'properties');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('main.error',compact(['message']));
        }
        $properties = $product->additional_properties;

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
            $this->pageService->getProductsNames($products);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('main.error',compact(['message']));
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
            return view('main.notfound',compact(['message']));
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
    public function userCreate()
    {
        $title = 'Регистрация на Медуса';
        $styles = 'css/user/create.css';
        return view('user.create',compact(['styles','title']));
    }
    public function login()
    {
        $title = 'Медуса - вход';
        $styles = 'css/user/create.css';
        return view('user.login',compact(['styles','title']));
    }
    public function productCreate()
    {
        $title = 'Создание категорий, подкатегорий и их продуктов';
        $pageService = $this->pageService;
        $categoryNames = json_encode($pageService->getCategories());
        $subcategoryNames = json_encode($pageService->getSubcategories());
        $styles = 'css/productCreate.css';
        return view('product.create',compact(['styles','categoryNames','subcategoryNames','title']));
    }
    public function products()
    {
        $product = new Product();
        $products = $this->pageService->getAllRecorts($product);
    }
    public function categories()
    {
        $title = '';
        $styles = 'css/main/categories.css';
        $category = new Category();
        try {
            $categories = $this->pageService->getAllRecorts($category);
            $categories->each(function ($category){
                $category->getUsabilityTime($category->created_at);
                $this->pageService->getModelProperties($category,'name');
            });
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('warning', $message);
        }
        return view('main.categories',compact(['categories','styles','title']));
    }
    public function categoryEdit(Category $category)
    {

    }
    public function subcategoryEdit()
    {

    }
    public function subcategories()
    {

    }
}
