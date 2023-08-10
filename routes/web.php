<?php

use App\Http\Controllers\cms\AdminController;
use App\Http\Controllers\cms\CityController;
use App\Http\Controllers\cms\CountryController;
use App\Http\Controllers\cms\CustomerController;
use App\Http\Controllers\cms\SellerController;
use App\Http\Controllers\cms\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// front route
Route::get('/front/home', function () {
    return view('front.index');
});


// dashboard route
Route::prefix('cms')->group(function(){

    Route::view('/home' , 'cms.home')->name('home');

    Route::resource('countries' , CountryController::class);
    Route::post('countries-update/{id}' , [CountryController::class , 'update'])->name('countries-update');

    Route::resource('cities' , CityController::class);
    Route::post('cities-update/{id}' , [CityController::class , 'update'])->name('cities-update');

    Route::resource('admins' , AdminController::class);
    Route::post('admins-update/{id}' , [AdminController::class , 'update'])->name('admins-update');

    Route::resource('sellers' , SellerController::class);
    Route::post('sellers-update/{id}' , [SellerController::class , 'update'])->name('sellers-update');

    Route::resource('customers' , CustomerController::class);
    Route::post('customers-update/{id}' , [CustomerController::class , 'update'])->name('customers-update');
});


// login route
Route::prefix('/')->group(function(){
    Route::get('login', [UserAuthController::class,'showLogin'])->name('dashboard.login');
    Route::post('login', [UserAuthController::class,'login'])->name('dashboard.login');

});