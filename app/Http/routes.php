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

/**********Vincent*************/

Route::get('auth/login','Auth\AuthController@loginPage');

Route::get('auth/register','Auth\AuthController@registerPage');

Route::get('memberCenter','GbhMobile\Member\MemberController@memberCenter');

Route::get('editUserInfo','GbhMobile\Member\MemberController@editUserInfoPage');

Route::get('orderListAll','GbhMobile\Order\OrderController@orderListAll');

Route::post('order/selectUnpaid','GbhMobile\Order\OrderController@selectUnpaid');

Route::post('order/selectOrderSuccess','GbhMobile\Order\OrderController@selectOrderSuccess');

Route::post('order/selectFinished','GbhMobile\Order\OrderController@selectFinished');

Route::get('orderInfo','GbhMobile\Order\OrderController@orderInfo');

Route::get('myCollection','GbhMobile\Collection\CollectionController@myCollection');

Route::get('evaluateHotel','GbhMobile\Evaluate\EvaluateController@evaluateHotel');

/************end*****************/


Route::get('/', 'GbhMobile\homeController@home');



