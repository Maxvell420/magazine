<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Predis\Client;

class CartService
{
    public function __construct(private TimeService $timeService,
                                private StorageService $storageService,
    )
    {}
    public function getCartProductIds(): ?array
    {
        // Получаем ID пользователя, если он аутентифицирован
        $user_id = Auth::check() ? Auth::id() : null;

        // Формируем ключ для доступа к данным корзины
        // Если пользователь не аутентифицирован, ключ будет "UserID:"
        // Если пользователь аутентифицирован, ключ будет "UserID:<user_id>"

        // Получаем данные корзины из хранилища или из куков
        // В случае если ключ в Redis не задан возвращает null
        $cartData = $this->getCartStorage($user_id) ?? $_COOKIE['cart'] ?? null;


        // Если данные корзины не найдены, возвращаем null
        if (!$cartData) {
            return null;
        }

        // Декодируем данные корзины и возвращаем идентификаторы продуктов
        return json_decode($cartData)->products;
    }
    public function createNewCartCookie(string $cartValue)
    {
        $expiryInSeconds = now()->addMinutes(5)->diffInSeconds(now());
        return cookie('cart', $cartValue, $expiryInSeconds, '/', null, false, false, true, 'Lax');
    }
    public function deleteProductsFromCart(Collection $products)
    {
        $user_id = Auth::id();

        $productsToDeleteIds = $products->pluck('id')->toArray();
        $ids = $this->getCartProductIds();
        $remainingProductIds = array_diff_assoc($ids,$productsToDeleteIds);
        $cart = [
            'products' => $remainingProductIds,
            'last_access' => gmdate('D, d M Y H:i:s \G\M\T', strtotime(now()))
        ];

        $jsonCart = json_encode($cart);
        $this->updateCartStorage($jsonCart,$user_id);
        return $this->createNewCartCookie($jsonCart);
    }

    /*
     * Вызывать метод только если пользователь авторизован
     */
    public function handleCookieProducts(string $jsonCookieData = null): ?string
    {
        $user_id = Auth::id();
        $cartDataJson = $this->getCartStorage($user_id);
        if (!$cartDataJson) {
            // Если нет данных в Redis
            if (!$jsonCookieData) {
                return null; // Нет данных ни в Redis, ни в cookie
            } else {
                // Обновляем данные в хранилище
                $this->updateCartStorage($jsonCookieData, $user_id);
                return $jsonCookieData;
            }
        } else {
            // Если есть данные в Redis
            if (!$jsonCookieData) {
                return $cartDataJson; // если нет данных в куки
            } else {
                // Сравниваем временные метки последнего доступа
                $cookieData = json_decode($jsonCookieData);
                $cartData = json_decode($cartDataJson);

                if ($this->isCookieFresher($cookieData->last_access,$cartData->last_access)) {
                    // Если данные в cookie более актуальны, обновляем Redis
                    $this->updateCartStorage($jsonCookieData, $user_id);
                    return $jsonCookieData;
                } else {
                    return $cartDataJson; // Возвращаем данные из Redis
                }
            }
        }
    }
    private function isCookieFresher(string $cookieTimeStr, string $redisTimeStr):bool
    {
        $cookieUnix = $this->timeService->getUnixTime($cookieTimeStr);
        $redisUnix = $this->timeService->getUnixTime($redisTimeStr);
        return  $this->timeService->compareUnixDates($cookieUnix,$redisUnix);
    }
    private function updateCartStorage(string $jsonData,string $user_id): void
    {
        $this->storageService->updateCartStorage($jsonData,$user_id);
    }
    private function getCartStorage(?string $user_id): ?string
    {
        if (!$user_id){
            return null;
        }
        return $this->storageService->getCartStorage($user_id);
    }
}
