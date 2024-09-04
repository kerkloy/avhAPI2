<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ModifiedOController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ModifiedSController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UpdateUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('customers', 'App\Http\Controllers\CustomerController')->names('customer');
    Route::apiResource('suppliers', 'App\Http\Controllers\SupplierController')->names('supplier');
    Route::apiResource('orders', 'App\Http\Controllers\OrderController')->names('orders');
    Route::apiResource('products', 'App\Http\Controllers\ProductController')->names('products');
    Route::apiResource('sales', 'App\Http\Controllers\SaleController')->names('sales');
    Route::apiResource('dashboard', 'App\Http\Controllers\DashboardController')->names('dashboard');
    
    Route::get('quantitysold', 'App\Http\Controllers\DashboardController@getSalesByBrand');
    Route::get('print/{id}', 'App\Http\Controllers\SaleController@getSaleData');
    Route::get('brands', 'App\Http\Controllers\OrderController@getBrand');
    Route::get('customer', 'App\Http\Controllers\OrderController@getCustomers');
    Route::post('purchase', 'App\Http\Controllers\ModifiedSController@store');
    Route::post('/order/status/{id}', [ModifiedOController::class, 'index'])->name('order.status');
    Route::get('alert', 'App\Http\Controllers\AlertController@index');
    Route::get('userdetails', 'App\Http\Controllers\Auth\LoginController@getUserDetails');
    Route::put('userupdate', 'App\Http\Controllers\UpdateUserController@updateUser');
});

