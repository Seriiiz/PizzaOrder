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


Route::get('/', 'App\Http\Controllers\OrderController@index');
Route::get('/orders', 'App\Http\Controllers\OrderController@create');
Route::post('/store/orders', 'App\Http\Controllers\OrderController@store');
Route::delete('orders/{id}', 'App\Http\Controllers\OrderController@destroy');

Route::get('/addon', 'App\Http\Controllers\AddonController@index');

Route::any('{slug}', function(){
    return view('slug');
});