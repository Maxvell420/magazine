<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class OrderService
{
    private Collection $products;
    private Delivery $delivery;

    public function __construct(){}

    public function orderHandler(Collection $products,Delivery $delivery)
    {
        if (!$this->checkProductsAvailability($products)) {
            return redirect()->back()->with('message', 'На складе товара меньше чем в заказе');
        }

        $this->setProducts($products);
        $this->setDelivery($delivery);

        return $this;
    }
    public function createOrder(string|int $orderPrice)
    {
        $delivery = $this->getDelivery();
        $products = $this->getProducts();
        $productOrder = json_encode($this->mapProductQuantities($products));

        if ($delivery->id>0){
            $orderPrice+=$delivery->price;
        }
        $user_id = Auth::check() ? Auth::id() : null;
        return Order::query()->create(['delivery_id'=>$delivery->id,'products'=>$productOrder,'user_id'=>$user_id,'status'=>'Подготовка заказа','price'=>$orderPrice]);
    }
    public function attachHref(Collection $orders)
    {
        foreach ($orders as $order){
            $url = URL::route('order.show',$order);
            $order->setAttribute('href',$url);
        }
    }
    public function countOrderProducts(Order $order,Collection $products)
    {
        $quantity = 0;
        foreach ($products as $product){
            $quantity+=$product->total_quantity;
        }
        if ($order->delivery->id>1){
            $quantity+=1;
        }
        return $quantity;
    }
    private function mapProductQuantities(Collection $products)
    {
        $productOrder = [];

        foreach ($products as $product) {
            $productOrder[$product->id] = $product->total_quantity;
        }

        return $productOrder;
    }
    private function addDeliveryPrice()
    {

    }

    public function validateDelivery(Request $request): int|string
    {
        $deliveryIds = Delivery::query()->pluck('id')->toArray();
        $validated = $request->validate([
            'delivery' => ['required', 'in:' . implode(',', $deliveryIds)],
        ]);
        return $validated['delivery'];
    }
    public function getDelivery(): Delivery
    {
        return $this->delivery;
    }
    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    private function setProducts(Collection $products): Collection|\Illuminate\Http\RedirectResponse
    {
        return $this->products=$products;
    }
    /**
     * @param string $delivery
     * @return void
     */
    private function setDelivery(Delivery $delivery): void
    {
        $this->delivery = $delivery;
    }
    private function checkProductsAvailability(Collection $products): bool
    {
        foreach ($products as $product) {
            if ($product->quantity < $product->total_quantity) {
                return false;
            }
        }
        return true;
    }
}
