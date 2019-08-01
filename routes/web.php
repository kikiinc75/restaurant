<?php
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
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('table', 'TableController')->middleware('kasir')->except([
        'show'
    ]);
    Route::resource('categorie', 'CategorieController')->middleware('kasir')->except([
        'show'
    ]);
    Route::resource('product', 'ProductController')->except([
        'show'
    ]);
    Route::get('log', 'LogController@index');
    Route::resource('order', 'OrderController');
    Route::resource('item', 'ItemController')->except([
        'index', 'show', 'create'
    ]);
    Route::prefix('api')->group(function () {
        Route::get('/cart', 'CartController@getCart');
        Route::post('/cart', 'CartController@addToCart');
        Route::delete('/cart/{id}', 'CartController@removeCart');

        Route::get('/makanan', 'CartController@apiMakanan');
    });
    // order
    // Route::get('/transaction', 'OrderController@create')->name('order.transaksi');
    // Route::get('/transaction/{id}', 'OrderController@show')->name('order.show');
    // Route::get('/transaction/{id}/edit', 'OrderController@edit')->name('order.edit');
    // Route::post('/checkout', 'OrderController@store')->name('checkout.store');
    // Route::get('/order', 'OrderController@index')->name('checkout.index');
    // Route::get('/pay/{id}', 'OrderController@edit');
    // Route::put('/pay/{id}', 'OrderController@update');
});
