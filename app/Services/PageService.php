<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PageService
{
    public function __construct(private ModelService $modelService,
                                private ProductService $productService,
                                private CartService $cartService,
                                private OrderService $orderService){}

    public function getProductsFromCart(): ?Collection
    {
        $product_ids = $this->cartService->getCartProductIds();
        $products = $this->productService->getProducts($product_ids);
        if ($products){
            return $this->loadProductsData($products);
        }
        return $products;
    }
    public function loadProductsData(Collection $products):Collection
    {
        return $this->productService->loadProductsData($products);
    }
    public function getCategories(string|array $column = null):Collection
    {
        $model = new Category;
        return $this->modelService->getAllRecords($model,$column);
    }
    public function getCategoriesJson(string|array $column = null): bool|string
    {
        $model = new Category;
        return $this->modelService->getAllRecordsJson($model,$column);
    }
    public function getSubcategories(string|array $column = null):Collection
    {
        if ($column){
            return Subcategory::all($column);
        }
        return Subcategory::all();
    }
    public function getSubcategoriesJson(string|array $column = null): bool|string
    {
        $model = new Subcategory;
        return $this->modelService->getAllRecordsJson($model,$column);
    }
    public function getProductsProperties($products = null): array
    {
        $products = $products ?? Product::all();
        return $this->productService->getProductsAdditionalProperties($products);
    }
    public function getProductProperties(Product $product): array
    {
        return $this->productService->getProductAdditionalProperties($product);
    }
    public function getFilteredProducts(Request $request):Collection
    {
        $products = $this->productService->getFilteredProducts($request);
        return $this->loadProductsData($products);
    }
//    Метод getProductsPrice используется только после того как были добавлены аттрибуты в productService методом setProductsCartParams
    public function getProductsPrice(Collection $products): int
    {
        return $this->productService->getProductsTotalPrice($products);
    }

    /**
     * @throws \Exception
     */
    public function getOrderedProductsFromRequest(Request $request): ?Collection
    {
        $orderedProducts = $request->except(['_token','delivery']);
        $products = $this->getProducts(array_keys($orderedProducts));
        return $this->productService->setProductsCartParams($orderedProducts,$products);
    }

    /**
     * @throws \Exception
     */
    public function getOrderedProducts(Order $order): ?Collection
    {
        $orderedProducts = json_decode($order->products,true);
        $products = $this->getProducts(array_keys($orderedProducts));
        return $this->productService->setProductsCartParams($orderedProducts,$products);
    }
    public function getDelivery(Request $request)
    {
        $id = $request->input('delivery');
        $delivery = new Delivery();
        return $this->modelService->getRecord($delivery,$id);
    }
    public function createOrder(Collection $products, Delivery $delivery): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $this->orderService->orderHandler($products,$delivery);
        $orderPrice= $this->getProductsPrice($products);
        return $this->orderService->createOrder($orderPrice);
    }
    public function getOrderQuantity(Order $order,Collection $products)
    {
        return $this->orderService->countOrderProducts($order,$products);
    }
    public function getProducts(array $ids,$column = null)
    {
        $product = new Product();
        return $this->modelService->getRecords($product,$ids,$column);
    }
    public function getUserOrders(User $user):Collection
    {
        return $user->orders()->get();
    }
    public function getUserFavourites():array
    {
        if (Auth::check()){
            $user = Auth::user();
            $favourites=$user->products()->pluck('product_id')->toArray();
        } else {
            $favourites = [];
        }
        return $favourites;
    }
}
