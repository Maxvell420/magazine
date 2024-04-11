<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\PageService;
use App\Services\WordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OrderController
{
    private WordService $wordService;
    public function __construct(private PageService $pageService)
    {
    }
    public function edit(Request $request, Order $order)
    {
        $validated = $request->validate(['payed'=>'required','status'=>'required']);
        $order->update($validated);
        return redirect()->back();
    }
    public function save(Request $request)
    {
        try {
            $products = $this->pageService->getOrderedProductsFromRequest($request);
            $this->pageService->getProductsNames($products);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return view('error',compact(['message']));
        }
        $delivery = $this->pageService->getDelivery($request);
        $order = $this->pageService->createOrder($products,$delivery);
        $lang = App::getLocale();
        $path = '../public/sample/'.$lang.'/Шаблон.docx';
        $this->wordService=new WordService($path, $products, $order);
        $this->wordService->createWordDocument();
        $cookie = $this->pageService->deleteProductsFromCart($products);
        return redirect()->route($lang.'.'.'order.show',[$order])->withCookie($cookie);
    }
}
