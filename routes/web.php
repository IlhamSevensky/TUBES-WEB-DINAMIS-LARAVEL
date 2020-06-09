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
Route::post('/admin/transaction/detail', 'AdminController@salesDetail');
Route::get('/admin/users', 'PagesController@usersPage');
Route::post('/admin/users/add', 'AdminController@userAdd');
Route::post('/admin/users/edit', 'AdminController@userEdit');
Route::post('/admin/users/avatar', 'AdminController@userUpdateAvatar');
Route::post('/admin/users/delete', 'AdminController@userDelete');
Route::post('/admin/users/detail', 'AdminController@userDetail');
Route::get('/admin/users/{id}/cart', 'AdminController@userCart');
Route::get('/admin/products', 'PagesController@productPage');
Route::get('/admin/products/{category_slug}', 'PagesController@product');
Route::post('/admin/products/detail', 'AdminController@productDetail');
Route::post('/admin/products/category/fetch', 'AdminController@categoryFetch');
Route::post('/admin/products/add', 'AdminController@productAdd');
Route::post('/admin/products/edit', 'AdminController@productEdit');
Route::post('/admin/products/delete', 'AdminController@productDelete');




