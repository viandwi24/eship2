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
        Route::create(['departure' => 'Pelabuhan Umum Gresik', 'arrival' => 'Pelabuhan Penyebrangan Bawean']);
        Route::create(['departure' => 'Pelabuhan Penyebrangan Bawean', 'arrival' => 'Pelabuhan Umum Gresik']);
    }
}
