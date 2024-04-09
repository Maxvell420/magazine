<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Delivery;
use App\Models\House;
use App\Models\Language;
use App\Models\Photo;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->create(['name'=>'user']);
        Role::query()->create(['name'=>'seller']);
        Role::query()->create(['name'=>'admin']);
         \App\Models\User::factory(1)->create();
         Delivery::query()->create(['name'=>'pickup','price'=>0]);
        Delivery::query()->create(['name'=>'courier','price'=>1000]);
        Language::query()->create(['name'=>'en']);
        Language::query()->create(['name'=>'ru']);
    }
}
