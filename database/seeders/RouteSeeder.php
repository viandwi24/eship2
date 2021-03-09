<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Route::create(['departure' => 'Gresik', 'arrival' => 'Bawean']);
        Route::create(['departure' => 'Bawean', 'arrival' => 'Gresik']);
    }
}
