<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\HomeController as DashboardHomeController;
use App\Http\Controllers\Dashboard\WeatherController as DashboardWeatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::group([
    'prefix' => 'dashboard',
    'middleware' => ['auth']
], function () {
    Route::get('/', [DashboardHomeController::class, 'index'])->name('dashboard');
    Route::resource('/weather', DashboardWeatherController::class);
});

// 
Route::group([
], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login_post'])->name('login.post')->middleware('guest');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});