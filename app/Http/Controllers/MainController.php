<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
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
        return redirect()->route('ru.main.dashboard');
    }
    public function cart()
    {
        $title = trans('routes.titles.main.cart');
        try {
            $products = $this->pageService->getProductsFromCart();
            $this->pageService->getProductsNames($products,40);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('main.error',compact(['message']));
        }
        $styles = 'css/main/cart.css';
        return view('main.cart',compact(['products','styles','title']));
    }
    public function productEdit(Product $product)
    {
        $title = trans('routes.titles.product.edit',['product_id'=>$product->name]);
        $styles ='css/main/productEdit.css';
        try {
            $this->pageService->getModelProperties($product,'properties');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('warning', $message);
        }
        $product->loadExternalData();
        $properties = $product->additional_properties??[];
        return view('main.productEdit',compact(['properties','styles','title','product']));
    }
    public function dashboard(Request $request)
    {
        $title = trans('routes.titles.main.dashboard');
        $styles = 'css/main/dashboard.css';
        $pageService = $this->pageService;
        $subcategories = json_encode($pageService->getSubcategories());
        $categories = json_encode($pageService->getCategories());
        $productsProperties = json_encode($pageService->getProductsProperties());
        $products = $pageService->getFilteredProducts($request)->take(12);
        $this->pageService->getProductsNames($products,30);
        $products->each(function ($item){
            $this->pageService->setPreviewInfo($item,4);
        });
        $favourites = $this->pageService->getUserFavourites();
        return view('main.dashboard',compact(['categories','subcategories','products','productsProperties','styles','favourites','title']));
    }
    public function ajaxDashboard(Request $request)
    {
        $pageService = $this->pageService;
        $ids = $request->input('products');
        $products = $pageService->getFilteredProducts($request);
        $products = $products->reject(function($product) use ($ids){
            return in_array($product->id, $ids);
        })->take(3);
        if ($products->isNotEmpty()){
            $result = [];
            foreach ($products as $product){
                $token = csrf_token();
                $this->pageService->getProductsNames($products,30);
                $products->each(function ($item){
                    $this->pageService->setPreviewInfo($item,4);
                });
//            $this->pageService->getModelProperties($product,'properties');
                $favourites = $this->pageService->getUserFavourites();
                $result[$product->id] = view('components.products.plate', compact(['product', 'favourites', 'token']))->render();
            }
            return json_encode($result);
        }
        return null;
    }

    public function favourites()
    {
        $title = trans('routes.titles.main.favourites');
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
        try {
            $this->pageService->getModelProperties($product,'properties');
            $this->pageService->setPreviewInfo($product,8);
        } catch (\Exception $e) {
            if ($e->getMessage() == 'foreach() argument must be of type array|object, null given'){
                $message = trans('errors.productShowLang');
            } else{
                $message = $e->getMessage();
            }
            return view('main.error',compact(['message']));
        }
        $favourites = $this->pageService->getUserFavourites();
        $product->loadExternalData();
        $title = trans('routes.titles.main.product',['name'=>$product->name??'']);
        $styles = 'css/main/product.css';
        return view('main.product',compact(['styles','product','favourites','title']));
    }
    public function checkout(Request $request)
    {
        $title = trans('routes.titles.main.checkout');
        try {
            $products = $this->pageService->getOrderedProductsFromRequest($request);
            $this->pageService->getProductsNames($products,40);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('main.error',compact(['message']));
        }
        $deliveries = Delivery::all();
        $totalPrice = $this->pageService->getProductsPrice($products);
        $styles = 'css/main/checkout.css';
        return view('main.checkout',compact(['products','styles','deliveries','totalPrice','title']));
    }
    public function orderShow(Order $order)
    {
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
        $title = trans('routes.titles.order.show',['Order_id'=>$order->id]);
        return view('main.order',compact(['products','order','filepath','delivery','orderQuantity','styles','title']));
    }
    public function adminBoard(Request $request)
    {
        $styles = 'css/main/adminka.css';
        $orders = $this->pageService->getOrders($request);
        $date = date('Y-m-d');
        $newOrders = $orders->filter(function($order) use ($date){
            return $date == $order->created_at->format('Y-m-d');
        });
        $title = trans('routes.titles.main.admin');
        $this->pageService->attachHrefToOrder($orders);
        return view('main.adminka',compact(['orders','newOrders','styles','title']));
    }
    public function orders()
    {
        $title = trans('routes.titles.main.orders');
        $user = Auth::user();
        $orders = $this->pageService->getUserOrders($user);
        $styles = 'css/main/orders.css';
        return view('main.orders',compact(['orders','styles','title']));
    }
    public function userCreate()
    {
        $title = trans('routes.titles.user.create');
        $styles = 'css/user/create.css';
        return view('user.create',compact(['styles','title']));
    }
    public function login()
    {
        $title = trans('routes.titles.main.login');
        $styles = 'css/user/create.css';
        return view('user.login',compact(['styles','title']));
    }
    public function productCreate()
    {
        $title = trans('routes.titles.product.create');
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
        $title = trans('routes.titles.main.categories');
        return view('main.categories',compact(['categories','styles','title']));
    }
    public function categoryEdit(Category $category)
    {
        $styles = 'css/main/category.css';
        $category->load('products');
        try {
            $category->load('products');
            $this->pageService->getModelProperties($category,'name');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('warning', $message);
        }
        $title = trans('routes.titles.category.edit',['category_id'=>$category->id]);
        return view('main.category',compact(['category','styles','title']));
    }
    public function subcategoryEdit(Subcategory $subcategory)
    {
        $styles = 'css/main/subcategory.css';
        $title = '';
        $subcategory->load('products');
        try {
            $subcategory->load('products');
            $this->pageService->getModelProperties($subcategory,'name');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('warning', $message);
        }
        $title = trans('routes.titles.subcategory.edit',['subcategory_id'=>$subcategory->id]);
        return view('main.subcategory',compact(['subcategory','styles','title']));
    }
    public function subcategories()
    {
        $styles = 'css/main/subcategories.css';
        $subcategory = new Subcategory();
        try {
            $subcategories = $this->pageService->getAllRecorts($subcategory);
            $subcategories->each(function ($subcategory){
                $subcategory->getUsabilityTime($subcategory->created_at);
                $this->pageService->getModelProperties($subcategory,'name');
            });
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('warning', $message);
        }
        $title = trans('routes.titles.main.categories');
        return view('main.subcategories',compact(['subcategories','styles','title']));
    }
}
