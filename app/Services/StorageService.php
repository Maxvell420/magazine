<?php

namespace App\Services;

use App\Models\Storage;
use Predis\Client;

class StorageService
{
    private Client $redis;
    public function __construct()
    {

        $storageDriver = env('STORAGE_SERVICE_KEY');
        if ($storageDriver ==='REDIS'){
            $this->redis = new Client();
        }
    }
    public function getCartStorage(?string $user_id)
    {
        if (isset($this->redis)){
            return $this->getCartStorageRedis($user_id);
        } else{
            return $this->getCartStorageDatabase($user_id);
        }
    }
    public function updateCartStorage(string $jsonData,?string $user_id)
    {
        if (isset($this->redis)){
            $this->setCartStorageRedis($jsonData,$user_id);
        } else{
            $this->setCartStorageDatabase($jsonData,$user_id);
        }
    }
    private function getCartStorageRedis(string $user_id)
    {
        $key = "UserID:$user_id";
        return $this->redis->get($key);
    }
    private function getCartStorageDatabase(string $user_id)
    {
        $storage = Storage::find($user_id);
        return $storage?->json;
    }
    private function setCartStorageDatabase(string $jsonData,string $user_id)
    {
        $storage = Storage::query()->firstOrCreate(['user_id' => $user_id],['user_id'=>$user_id,'json' => $jsonData]);
        if (!$storage->wasRecentlyCreated){
            $storage->update(['json'=>$jsonData]);
        }
    }
    private function setCartStorageRedis(string $jsonData,string $user_id): void
    {
        $key = "UserID:$user_id";
        $this->redis->set($key,$jsonData);
    }
}
