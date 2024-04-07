<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateCartMiddleware
{
    public function __construct(private CartService $cartService)
    {
    }

    /**
     * Handle an incoming request.
     * Производит манипуляции с куками и хранилищем корзины (где данные более свежие те и сохраняются)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $cartData = $_COOKIE['cart'] ?? null;
            $cartValue = $this->cartService->handleCookieProducts($cartData);
            $expiryInSeconds = now()->addMinutes(5)->diffInSeconds(now());
            $cookie = cookie('cart', $cartValue, $expiryInSeconds, '/', null, false, false, true, 'Lax');
            return $next($request)->cookie($cookie);
        }

        return $next($request);
    }
}
