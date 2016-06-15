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
Route::get('/search','GbhMobile\HomeController@search');
Route::get('/hotel/{hotelId}','GbhMobile\Hotel\HotelController@hotelDetail');
Route::get('/hotel/{hotelId}/booking/{roomId}','GbhMobile\Hotel\HotelController@booking');

Route::get('/admin/manageHotel','Admin\Hotel\HotelController@index');
Route::get('/admin/manageHotel/create','Admin\Hotel\HotelController@createHotel');

Route::get('/admin/manageHotel/create/geolocation','Admin\Hotel\HotelController@geolocation');

Route::post('/admin/manageHotel/create','Admin\Hotel\HotelController@storeHotel');


Route::get('/admin/manageArticle','Admin\Article\ArticleController@index');
Route::get('/admin/manageArticle/create','Admin\Article\ArticleController@createArticle');
Route::post('/admin/manageArticle/create','Admin\Article\ArticleController@storeArticle');

Route::get('admin/manageArticle/classificationandtag','Admin\Article\ArticleController@classificationandtag');

Route::post('/admin/manageArticle/addArticleTag','Admin\Article\ArticleController@addArticleTag');
Route::post('/admin/manageArticle/delArticleTag','Admin\Article\ArticleController@delArticleTag');
Route::post('/admin/manageArticle/classificationOperate','Admin\Article\ArticleController@classificationOperate');
Route::post('/admin/manageArticle/delArticleCategory','Admin\Article\ArticleController@delArticleCategory');

/*******************************end**************************************/




/******************************GbhAdmin**************************************/

/*************************Vincent*********************************/

Route::get('/admin/Login','Admin\homeController@login');

Route::post('/admin/Sign','Admin\homeController@toSign');

Route::get('/AdminCenter','Admin\homeController@index');

Route::get('admin/menuSetting','Admin\Menu\MenuSettingController@index');

Route::group(['prefix' => 'menuSetting'], function() {
    Route::post('getSecondMenu','Admin\Menu\MenuSettingController@getSecondMenu');

    Route::post('createMenu','Admin\Menu\MenuSettingController@createMenu');

    Route::post('uploadIcon','Admin\Menu\MenuSettingController@uploadIcon');

    Route::post('getMenuInfo','Admin\Menu\MenuSettingController@getMenuInfo');

    Route::post('menuDelete','Admin\Menu\MenuSettingController@menuDelete');

    Route::post('getFirstMenu','Admin\Menu\MenuSettingController@getFirstMenu');

});


Route::get('orderSearchPage','Admin\Order\OrderController@orderSearchPage');

// Route::group(['prefix' => 'admin/Order'], function() {
// 	Route::get('orderSearchPage','Admin\Order\OrderController@orderSearchPage');
// });



/************************end*************************************/


/******************************end*******************************************/