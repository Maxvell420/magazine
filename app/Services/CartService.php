<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Predis\Client;

class CartService
{
    public function __construct(private Client $redis,private TimeService $timeService)
    {}
    public function getCartProductIds(): ?array
    {
        // Получаем ID пользователя, если он аутентифицирован
        $user_id = Auth::check() ? Auth::id() : null;

        // Формируем ключ для доступа к данным корзины
        // Если пользователь не аутентифицирован, ключ будет "UserID:"
        // Если пользователь аутентифицирован, ключ будет "UserID:<user_id>"
        $key = "UserID:$user_id";

        // Получаем данные корзины из хранилища или из куков
        // В случае если ключ в Redis не задан возвращает null
        $cartData = $this->getCartStorage($key) ?? $_COOKIE['cart'] ?? null;


        // Если данные корзины не найдены, возвращаем null
        if (!$cartData) {
            return null;
        }

        // Декодируем данные корзины и возвращаем идентификаторы продуктов
        return json_decode($cartData)->products;
    }

    /*
     * Вызывать метод только если пользователь авторизован
     */
    public function handleCookieProducts(string $jsonCookieData = null): ?string
    {
        $user_id = Auth::user()->id;
        $key = "UserID:$user_id";
        $cartDataJson = $this->getCartStorage($key);
        if (!$cartDataJson) {
            // Если нет данных в Redis
            if (!$jsonCookieData) {
                return null; // Нет данных ни в Redis, ни в cookie
            } else {
                // Обновляем данные в хранилище
                $this->updateCartStorage($jsonCookieData, $key);
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
                    $this->updateCartStorage($jsonCookieData, $key);
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
    private function updateCartStorage(string $jsonData,string $key): void
    {
        $this->redis->set($key,$jsonData);
    }
    private function getCartStorage(string $key): ?string
    {
        return $this->redis->get($key);
    }
}
