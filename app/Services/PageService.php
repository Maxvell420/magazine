<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Language;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PageService
{
    private Language $language;
    public function __construct(private ModelService $modelService,
                                private ProductService $productService,
                                private CartService $cartService,
                                private OrderService $orderService,
                                private LocalizationService $localizationService){
        $lang = App::getLocale();
        $language = Language::firstWhere('name',$lang);
        $this->language = $language;
    }
    public function determineLang(string $url)
    {
        return $this->localizationService->changeAppLang($url);
    }
    public function getCategories()
    {
        $category = new Category();
        $language = $this->language;
        $records = $this->modelService->getRecordsManyToLanguage($category,$language);
        $this->modelService->getPivotPropertiesWithLanguage($records);
        return $this->modelService->flattenCollection($records,['id','name']);
    }
    public function getSubcategories(string|array $column = null): array
    {
        $subcategory = new Subcategory();
        $language = $this->language;
        $records = $this->modelService->getRecordsManyToLanguage($subcategory,$language);
        $this->modelService->getPivotPropertiesWithLanguage($records);
        return $this->modelService->flattenCollection($records,['id','name']);
    }
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
    public function getCategoriesJson(string|array $column = null): bool|string
    {
        $model = new Category;
        return $this->modelService->getAllRecordsJson($model,$column);
    }
    public function getProductsProperties($products = null): array
    {
        $products = $products ?? Product::all();
        return $this->productService->getProductsAdditionalProperties($products);
    }
    public function getOrders(Request $request)
    {
        $order = new Order();
        return $this->modelService->getAllRecords($order);
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
    public function attachHrefToOrder(Collection $orders)
    {
        $this->orderService->attachHref($orders);
    }
}
