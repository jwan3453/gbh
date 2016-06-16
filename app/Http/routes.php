<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*******************************GbhMibile*********************************************/

/**********Vincent*************/

Route::get('auth/login','Auth\AuthController@loginPage');

Route::get('auth/register','Auth\AuthController@registerPage');

Route::get('memberCenter','GbhMobile\Member\MemberController@memberCenter');

Route::get('editUserInfo','GbhMobile\Member\MemberController@editUserInfoPage');

Route::get('myCollection','GbhMobile\Collection\CollectionController@myCollection');

Route::get('evaluateHotel','GbhMobile\Evaluate\EvaluateController@evaluateHotel');


Route::group(['prefix' => 'order'], function() {
    Route::post('selectUnpaid','GbhMobile\Order\OrderController@selectUnpaid');

	Route::post('selectOrderSuccess','GbhMobile\Order\OrderController@selectOrderSuccess');

	Route::post('selectFinished','GbhMobile\Order\OrderController@selectFinished');

	Route::get('orderListAll','GbhMobile\Order\OrderController@orderListAll');

	Route::get('orderDetail/{ordersn}','GbhMobile\Order\OrderController@orderDetail');
});





/************end*****************/


//Route::get('/', 'GbhMobile\HomeController@home');
Route::get('/', 'Gbh\HomeController@home');
Route::get('/aboutUs','Gbh\HomeController@aboutUs');
Route::get('/joinUs','Gbh\HomeController@joinUs');
Route::get('/history', 'Gbh\HomeController@history');
Route::get('/contactUs','Gbh\HomeController@contactUs');
Route::get('/team','Gbh\HomeController@team');

Route::get('/search','GbhMobile\HomeController@search');
Route::get('/hotel/{hotelId}','GbhMobile\Hotel\HotelController@hotelDetail');
Route::get('/hotel/{hotelId}/booking/{roomId}','GbhMobile\Hotel\HotelController@booking');

Route::get('/gbh/login','Gbh\HomeController@login');
Route::get('/gbh/register','Gbh\HomeController@register');
Route::get('/gbh/PageNotFound','Gbh\HomeController@PageNotFound');



/*******************************end**************************************/




/******************************GbhAdmin**************************************/

/*************************Vincent*********************************/

Route::group(['prefix' => '/admin/', 'middleware' => 'App\Http\Middleware\AdminAuthenticate'], function() {
    Route::get('AdminCenter','Admin\homeController@index');

    Route::group(['prefix' => 'menuSetting/'], function() {
        Route::post('getSecondMenu','Admin\Menu\MenuSettingController@getSecondMenu');

        Route::post('createMenu','Admin\Menu\MenuSettingController@createMenu');

        Route::post('uploadIcon','Admin\Menu\MenuSettingController@uploadIcon');

        Route::post('getMenuInfo','Admin\Menu\MenuSettingController@getMenuInfo');

        Route::post('menuDelete','Admin\Menu\MenuSettingController@menuDelete');

        Route::post('getFirstMenu','Admin\Menu\MenuSettingController@getFirstMenu');

    });

    Route::get('orderSearchPage','Admin\Order\OrderController@orderSearchPage');

    Route::get('menuSetting','Admin\Menu\MenuSettingController@index');

    Route::get('manageHotel','Admin\Hotel\HotelController@index');
    Route::get('manageHotel/create','Admin\Hotel\HotelController@createHotel');

    Route::get('manageHotel/create/geolocation','Admin\Hotel\HotelController@geolocation');

    Route::post('manageHotel/create','Admin\Hotel\HotelController@storeHotel');


    Route::get('manageArticle','Admin\Article\ArticleController@index');
    Route::get('manageArticle/create','Admin\Article\ArticleController@createArticle');
    Route::post('manageArticle/create','Admin\Article\ArticleController@storeArticle');

    Route::get('manageArticle/classificationandtag','Admin\Article\ArticleController@classificationandtag');

    Route::post('manageArticle/addArticleTag','Admin\Article\ArticleController@addArticleTag');
    Route::post('manageArticle/delArticleTag','Admin\Article\ArticleController@delArticleTag');
    Route::post('manageArticle/classificationOperate','Admin\Article\ArticleController@classificationOperate');
    Route::post('manageArticle/delArticleCategory','Admin\Article\ArticleController@delArticleCategory');

    Route::get('Error/NotPermission','Admin\homeController@NotPermission');

});

Route::get('/admin/Login','Admin\homeController@login');

Route::post('/admin/Sign','Admin\homeController@toSign');



/************************end*************************************/


/******************************end*******************************************/