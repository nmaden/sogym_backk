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
        

    
  
    Route::get('/get/bonus/by/id', 'Api\v1\ProductsController@getBonusById');
            Route::get('/get/auth/bonus', 'Api\v1\ProductsController@getBonusAuth');

            Route::get('/search/bonus', 'Api\v1\ProductsController@searchBonus');
            
          
            Route::post('/update/bonus', 'Api\v1\ProductsController@updateBonus');
            Route::post('/create/bonus', 'Api\v1\ProductsController@createBonus');
            Route::post('/delete/bonus', 'Api\v1\ProductsController@deleteBonus');
            Route::post('/add/bonus', 'Api\v1\ProductsController@addBonus');
            Route::post('/use/bonus', 'Api\v1\ProductsController@useBonus');
            Route::get('/get/bonuses', 'Api\v1\ProductsController@getBonuses');

            Route::post('/create/info', 'Api\v1\ProductsController@createInfo');
            Route::post('/update/info', 'Api\v1\ProductsController@editInfo');
            Route::get('/get/info', 'Api\v1\ProductsController@getInfo');



            Route::post('/create/product', 'Api\v1\ProductsController@createProduct');
            Route::post('/get/product', 'Api\v1\ProductsController@getProduct');
            Route::get('/get/products', 'Api\v1\ProductsController@getProducts');
            Route::post('/get/products/admin/by/category', 'Api\v1\ProductsController@getProductsAdminByCategory');

            Route::post('/create/banner', 'Api\v1\ProductsController@createBanner');
            Route::post('/del/banner', 'Api\v1\ProductsController@deleteBanner');

            Route::get('/get/admin/products', 'Api\v1\ProductsController@getAdminProducts');

            Route::post('/set/category', 'Api\v1\ProductsController@setCategory');

            Route::post('/set/show/product', 'Api\v1\ProductsController@setShowProduct');

            Route::post('/find/product', 'Api\v1\ProductsController@findProduct');


            Route::post('/update/category', 'Api\v1\ProductsController@updateCategory');
            Route::get('/delete/category', 'Api\v1\ProductsController@deleteCategory');
            Route::post('/create/category', 'Api\v1\ProductsController@createCategory');


            Route::get('/delete/product/admin', 'Api\v1\ProductsController@deleteProductAdmin');


            Route::post('/delete/product', 'Api\v1\ProductsController@deleteProductAdmin');

            Route::post('/delete/product/duplicate', 'Api\v1\ProductsController@deleteProductDuplicate');



            Route::get('/delete/product/image', 'Api\v1\ProductsController@deleteProductImage');
            Route::post('/update/product', 'Api\v1\ProductsController@updateProduct');


            Route::get('/get/order', 'Api\v1\ProductsController@getOrder');
            Route::get('/get/orders/list', 'Api\v1\ProductsController@getOrders');

            Route::post('/delete/order', 'Api\v1\ProductsController@deleteOrder');

            Route::post('/delete/all/order', 'Api\v1\ProductsController@deleteAllOrder');



            Route::get('/get/orders', 'Api\v1\ProductsController@senderOrdersForC');
            Route::post('/update/to/sended', 'Api\v1\ProductsController@updateSended');


            Route::post('/update/count', 'Api\v1\ProductsController@updateCount');

            Route::post('/update/product/action/c', 'Api\v1\ProductsController@updateActionC');



        Route::post('/create/purchase', 'Api\v1\PurchaseController@createPurchase');
            Route::get('/get/applications', 'Api\v1\PurchaseController@getApplications');
            Route::post('/accept/application', 'Api\v1\PurchaseController@acceptApplication');


            Route::post('/get/user/me', 'Api\v1\ProductsController@me');


            // Route::get('/get/user/me', 'Api\v1\ProductsController@me');
            
            

            Route::get('/get/purchase', 'Api\v1\PurchaseController@getPurchase');
            Route::get('/delete/purchase', 'Api\v1\PurchaseController@deletePurchase');

            Route::get('/delete/application', 'Api\v1\PurchaseController@deleteApplication');
            Route::post('/update/purchase', 'Api\v1\PurchaseController@updatePurchase');
            Route::post('/fill/products', 'Api\v1\ProductsController@fillProduct');
            Route::post('/delete/all/products', 'Api\v1\ProductsController@deleteDuplicateProducts');
    });

    Route::get('/push/bonus', 'Api\v1\ProductsController@pushBonus');
    Route::get('/get/users', 'Api\v1\ProductsController@getUsers');


    Route::get('/get/asia/bonuses', 'Api\v1\ProductsController@getAsiaBonus');




    Route::get('/get/bonus', 'Api\v1\ProductsController@getBonus');
    Route::get('/get/banners', 'Api\v1\ProductsController@getBanners');

    Route::get('/get/duplicate/products', 'Api\v1\ProductsController@getDuplicateProducts');

    Route::get('/get/hotels', 'Api\v1\ProductsController@getHotels');

    Route::get('/guest/get/info', 'Api\v1\ProductsController@getInfo');


    Route::post('/guest/create/info', 'Api\v1\ProductsController@createInfo');

    Route::get('/guest/get/spec', 'Api\v1\ProductsController@getSpec');

    Route::get('/guest/get/products', 'Api\v1\ProductsController@getProducts');

    Route::post('/get/product/description', 'Api\v1\ProductsController@getProductDescription');


    Route::get('/search/product', 'Api\v1\ProductsController@searchProduct');



    Route::post('/create/order', 'Api\v1\ProductsController@createOrder');
    Route::post('/get/categories', 'Api\v1\ProductsController@getCategories');

    Route::get('/get/categories', 'Api\v1\ProductsController@getCategories');

    Route::get('/get/all/categories', 'Api\v1\ProductsController@getAllCategories');

    Route::post('/guest/get/products/by/category', 'Api\v1\ProductsController@getProductsByCategory');


    Route::post('/send/request', 'Api\v1\PurchaseController@sendRequest');

    Route::post('/create/application', 'Api\v1\PurchaseController@createApplication');
    Route::get('/get/by/category', 'Api\v1\PurchaseController@getPurchasesByCategory');

    Route::get('/get/purchases', 'Api\v1\PurchaseController@getPurchases');
    Route::post('/register', 'Api\v1\AuthController@register');
    Route::post('/login', 'Api\v1\AuthController@login');

    Route::post('/update/password', 'Api\v1\AuthController@updatePassword');

});

