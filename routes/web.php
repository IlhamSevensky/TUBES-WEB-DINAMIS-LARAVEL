<?php

use Illuminate\Support\Facades\Route;

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
 
Route::get('/', 'PagesController@index')->name('home');
Route::get('/category/{name}', 'PagesController@productByCategory');
Route::get('/product/{name}', 'PagesController@productDetail');
Route::get('/search', 'PagesController@searchProduct'); 
Route::post('/cart/add','CartController@cartAdd');  
Route::post('/cart/fetch', 'CartController@cartFetch');  

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', 'AuthController@loginPage')->name('login_page');
    Route::get('/register', 'AuthController@registerPage')->name('register_page');
    Route::post('/post_login', 'AuthController@login')->name('post_login');
    Route::post('/post_register', 'AuthController@register')->name('post_register');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'AuthController@logout');
    Route::get('/cart', 'PagesController@cartPage')->name('cart_page');
    Route::get('/profile', 'PlantShopController@profile')->name('profile_page');
    Route::post('/profile/edit', 'PlantShopController@editProfile');
    Route::post('/profile/transaction/detail', 'PlantShopController@profileDetailTransaction');
    Route::post('/cart/total', 'CartController@cartTotal');
    Route::post('/cart/detail', 'CartController@cartDetail');
    Route::post('/cart/update', 'CartController@cartUpdate');
    Route::post('/cart/delete', 'CartController@cartDelete');
    Route::post('/cart/checkout', 'CartController@cartCheckout');
});

// Admin Route
Route::get('/admin', 'PagesController@adminPage');
// View Parameter should be number only
Route::get('/admin/month/{year}', 'PagesController@dashboard')->where('year', '[0-9]+');
Route::get('/admin/sales', 'PagesController@salesPage');
Route::post('/admin/transaction/detail', 'PagesController@salesDetail');




