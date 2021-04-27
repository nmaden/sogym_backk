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


Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
            Route::post('/create/purchase', 'Api\v1\PurchaseController@createPurchase');
            Route::get('/get/applications', 'Api\v1\PurchaseController@getApplications');
            Route::post('/accept/application', 'Api\v1\PurchaseController@acceptApplication');  
            Route::post('/get/user/me', 'Api\v1\PurchaseController@me');            
            Route::get('/get/purchase', 'Api\v1\PurchaseController@getPurchase');
            Route::get('/delete/purchase', 'Api\v1\PurchaseController@deletePurchase');

            Route::get('/delete/application', 'Api\v1\PurchaseController@deleteApplication');
            Route::post('/update/purchase', 'Api\v1\PurchaseController@updatePurchase');

            Route::post('/create/category', 'Api\v1\PurchaseController@createCategory');
            Route::post('/update/category', 'Api\v1\PurchaseController@updateCategory');
            Route::get('/delete/category', 'Api\v1\PurchaseController@deleteCategory');
                
    });

    Route::post('/send/request', 'Api\v1\PurchaseController@sendRequest');

    Route::post('/create/application', 'Api\v1\PurchaseController@createApplication');
    Route::get('/get/by/category', 'Api\v1\PurchaseController@getPurchasesByCategory');
            
    Route::get('/get/categories', 'Api\v1\PurchaseController@getCategories');

    Route::get('/get/purchases', 'Api\v1\PurchaseController@getPurchases');
    Route::post('/register', 'Api\v1\AuthController@register');
    Route::post('/login', 'Api\v1\AuthController@login');
    
});

