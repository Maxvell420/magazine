<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\House;
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
        Role::query()->create(['name'=>'admin']);
         \App\Models\User::factory(1)->create();
    }
}
