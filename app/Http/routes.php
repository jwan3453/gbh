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


Route::get('/', 'GbhMobile\homeController@home');
Route::get('/search','GbhMobile\homeController@search');
Route::get('/hotel/{hotelId}','GbhMobile\Hotel\hotelController@hotelDetail');
Route::get('/hotel/{hotelId}/booking/{roomId}','GbhMobile\Hotel\hotelController@booking');

Route::get('/admin/manageHotel','Admin\hotelController@index');



/*******************************end**************************************/




/******************************GbhAdmin**************************************/

/*************************Vincent*********************************/

Route::get('/AdminCenter','Admin\homeController@index');

Route::get('menuSetting','Admin\MenuSetting\MenuSettingController@index');

Route::group(['prefix' => 'menuSetting'], function() {
    Route::post('getSecondMenu','Admin\MenuSetting\MenuSettingController@getSecondMenu');

});

/************************end*************************************/


/******************************end*******************************************/