<?php

namespace App\Services;

use Illuminate\Support\Facades\App;

class LocalizationService
{
    public function changeAppLang(string $url)
    {
        if (str_starts_with($url,'api/')){
            $url = preg_replace('#^api/*#', '', $url);
        }
        if(str_starts_with($url, 'ru')){
            app()->setLocale('ru');
        }
    }
}
