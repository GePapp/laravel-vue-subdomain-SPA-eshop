<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ------  Admin area -------
Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::get('/users', 'API\UserController@index');
    Route::delete('/users/destroy/{user}', 'API\UserController@destroy');
    // Maps
    Route::get('/map', 'API\MapController@index');
    Route::get('/map/show/{id}', 'API\MapController@show');
    Route::post('/map/store', 'API\MapController@store');
    Route::put('/map/update/{id}', 'API\MapController@update');
    Route::delete('/map/destroy/{id}', 'API\MapController@destroy');
    // Orders
    Route::get('getOrders', 'API\OrderController@index');
    Route::get('findOrders', 'API\OrderController@search');
    Route::put('setChecked/{id}', 'API\OrderController@setChecked');
    Route::get('findUnChecked', 'API\OrderController@selectUnChecked');
    Route::get('printOrder/{id}', 'API\OrderController@printOrder');
});

// ------  Pubic Pages -------
// shop
Route::get('/publicMap', 'API\MapController@index');
Route::get('/publicMap/show/{id}', 'API\MapController@show');
// store order
Route::post('/publicStoreOrder', 'API\OrderController@storeOrder');