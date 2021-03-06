<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'verify' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/cart/add',[
    'uses' => 'OrderController@addToCart',
    'as' => 'cart.add'
]);

Route::get('/cart/rapid/add/{id}',[
    'uses' => 'OrderController@rapidAdd',
    'as' => 'cart.rapid.add'
]);

