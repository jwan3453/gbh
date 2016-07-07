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

Route::get('auth/login','Auth\AuthController@loginPage');

Route::get('auth/register','Auth\AuthController@registerPage');

Route::get('memberCenter','GbhMobile\Member\MemberController@memberCenter');

Route::get('editUserInfo','GbhMobile\Member\MemberController@editUserInfoPage');

Route::get('myCollection','GbhMobile\Collection\CollectionController@myCollection');

Route::get('evaluateHotel','GbhMobile\Evaluate\EvaluateController@evaluateHotel');

Route::get('/search','GbhMobile\HomeController@search');

Route::get('/hotel/{hotelId}','GbhMobile\Hotel\HotelController@hotelDetail');

Route::get('/hotel/{hotelId}/booking/{roomId}','GbhMobile\Hotel\HotelController@booking');



Route::group(['prefix' => 'order'], function() {
    Route::post('selectUnpaid','GbhMobile\Order\OrderController@selectUnpaid');

	Route::post('selectOrderSuccess','GbhMobile\Order\OrderController@selectOrderSuccess');

	Route::post('selectFinished','GbhMobile\Order\OrderController@selectFinished');

	Route::get('orderListAll','GbhMobile\Order\OrderController@orderListAll');

	Route::get('orderDetail/{ordersn}','GbhMobile\Order\OrderController@orderDetail');
});


/************end*****************/




/**********Gbh website***************/


Route::get('/', 'Gbh\HomeController@home');

Route::get('/newArticles', 'Gbh\HomeController@newArticles');

Route::get('/aboutUs','Gbh\HomeController@aboutUs');

Route::get('/joinUs','Gbh\HomeController@joinUs');

Route::get('/history', 'Gbh\HomeController@history');

Route::get('/contactUs','Gbh\HomeController@contactUs');

Route::get('/team','Gbh\HomeController@team');

Route::get('/article/{articleId}', 'Gbh\ArticleController@showArticle');

Route::post('/getArticleByCate','Gbh\ArticleController@getArticleByCate');

Route::get('/gbh/login','Gbh\HomeController@login');

Route::get('/gbh/register','Gbh\HomeController@register');

Route::get('/gbh/PageNotFound','Gbh\HomeController@PageNotFound');

Route::post('/gbh/article/praise','Gbh\ArticleController@praise');

/*******************************end**************************************/






/*************************AdminCenter*********************************/

Route::group(['prefix' => '/admin/', 'middleware' => 'App\Http\Middleware\AdminAuthenticate'], function() {
    Route::get('AdminCenter','Admin\homeController@index');

    //--------菜单设置
    Route::get('menuSetting','Admin\Menu\MenuSettingController@index');
    Route::group(['prefix' => 'menuSetting/'], function() {
        Route::post('getSecondMenu','Admin\Menu\MenuSettingController@getSecondMenu');

        Route::post('createMenu','Admin\Menu\MenuSettingController@createMenu');

        Route::post('uploadIcon','Admin\Menu\MenuSettingController@uploadIcon');

        Route::post('getMenuInfo','Admin\Menu\MenuSettingController@getMenuInfo');

        Route::post('menuDelete','Admin\Menu\MenuSettingController@menuDelete');

        Route::post('getFirstMenu','Admin\Menu\MenuSettingController@getFirstMenu');

    });

    //---------酒店管理
    Route::get('manageHotel','Admin\Hotel\HotelController@index');

    Route::group(['prefix' => 'manageHotel/'], function() {

        Route::get('hotelInfo/{hotelId}','Admin\Hotel\HotelController@HotelInfo');

        Route::get('create/geolocation','Admin\Hotel\HotelController@geolocation');

        Route::post('create','Admin\Hotel\HotelController@storeHotel');

        Route::get('create','Admin\Hotel\HotelController@createHotel');

        Route::get('create/geolocation/{hotelId}','Admin\Hotel\HotelController@geolocation');

        Route::get('create/facility/{hotelId}','Admin\Hotel\HotelController@facility');

        Route::get('create/contactAndPayment/{hotelId}','Admin\Hotel\HotelController@contactAndPayment');

        //管理房间
        Route::get('hotelInfo/{hotelId}/manageRoom','Admin\Hotel\HotelController@manageRoom');

        //编辑房间
        Route::get('hotelInfo/{hotelId}/editRoom/{roomId}','Admin\Hotel\HotelController@editRoom');

        //创建房间
        Route::post('/createNewRoom','Admin\Hotel\HotelController@createNewRoom');

        //更新房间
        Route::post('/updateRoom','Admin\Hotel\HotelController@updateRoom');

        Route::post('insertPolicy','Admin\Hotel\HotelController@insertPolicy');

        Route::post('insertContactPayment','Admin\Hotel\HotelController@insertContactPayment');

        Route::post('insertFacility','Admin\Hotel\HotelController@insertFacility');

        Route::get('createHotelError/{errorid}/{hotelId}','Admin\Hotel\HotelController@createHotelError');

        Route::post('selectUpOrDown','Admin\Hotel\HotelController@selectUpOrDown');
        Route::post('itemUpOrDown','Admin\Hotel\HotelController@itemUpOrDown');

        Route::get('editHotel/{hotelId}','Admin\Hotel\HotelController@editHotel');
        Route::get('editGeoLocation/{hotelId}','Admin\Hotel\HotelController@editGeoLocation');
        Route::get('editPaymentAndContact/{hotelId}','Admin\Hotel\HotelController@editPaymentAndContact');
        Route::get('editFacility/{hotelId}','Admin\Hotel\HotelController@editFacility');

        //管理酒店图片
        Route::get('hotelInfo/{hotelId}/manageHotelImage','Admin\Hotel\HotelController@manageHotelImage');

        Route::post('uploadImage','Admin\Hotel\HotelController@uploadImage');

        Route::post('deleteHotelImage','Admin\Hotel\HotelController@deleteHotelImage');

        Route::post('coverHotelImage','Admin\Hotel\HotelController@coverHotelImage');

    });

    //----------文章管理
    Route::get('manageArticle','Admin\Article\ArticleController@index');
    Route::group(['prefix' => 'manageArticle/'], function() {
        Route::get('create','Admin\Article\ArticleController@createArticle');

        Route::post('create','Admin\Article\ArticleController@storeArticle');

        Route::get('classificationandtag','Admin\Article\ArticleController@classificationandtag');

        Route::get('edit/{articleId}','Admin\Article\ArticleController@editArticle');
        
        Route::post('edit/{articleId}','Admin\Article\ArticleController@updateArticle');

        Route::post('addArticleTag','Admin\Article\ArticleController@addArticleTag');
        
        Route::post('delArticleTag','Admin\Article\ArticleController@delArticleTag');
        
        Route::post('classificationOperate','Admin\Article\ArticleController@classificationOperate');
        
        Route::post('delArticleCategory','Admin\Article\ArticleController@delArticleCategory');
        
        Route::post('articleOnline','Admin\Article\ArticleController@articleOnline');
        
        Route::post('articleOffline','Admin\Article\ArticleController@articleOffline');
        
        Route::post('delArticle','Admin\Article\ArticleController@delArticle');

        Route::get('edit/{articleId}','Admin\Article\ArticleController@editArticle');
        
        Route::post('edit/{articleId}','Admin\Article\ArticleController@updateArticle');

        Route::post('articleToTop','Admin\Article\ArticleController@articleToTop');

        Route::post('articleCancelTop','Admin\Article\ArticleController@articleCancelTop');
    });

    //--------系统设置
    Route::group(['prefix' => 'system/'], function() {
        //-------轮播图设置---
        Route::get('slideConfigure','Admin\System\SystemController@slideConfigure');
        Route::post('uploadImg','Admin\System\SystemController@uploadImg');
        Route::post('createSlide','Admin\System\SystemController@createSlide');
        Route::post('delSlide','Admin\System\SystemController@delSlide');

        //--------信用卡、银行卡管理---
        Route::get('creditCardManage','Admin\System\SystemController@creditCardManage');
        Route::post('createCreditCard','Admin\System\SystemController@createCreditCard');
        Route::post('delCredit','Admin\System\SystemController@delCredit');

        //--------酒店服务项目------
        Route::get('serviceItems','Admin\System\SystemController@serviceItems');
        Route::post('createServiceItem','Admin\System\SystemController@createServiceItem');
        Route::post('delitem','Admin\System\SystemController@delitem');

        //--------酒店服务分类-------
        Route::get('serviceSetting','Admin\System\SystemController@serviceSetting');
        Route::post('createServiceCategory','Admin\System\SystemController@createServiceCategory');
        Route::post('delServiceCategory','Admin\System\SystemController@delServiceCategory');

        //--------酒店图片分类管理----
        Route::get('hotelImageManage','Admin\System\SystemController@hotelImageManage');
        Route::post('hotelImageOperation','Admin\System\SystemController@hotelImageOperation');
        Route::post('delhotelImage','Admin\System\SystemController@delhotelImage');
    });

    //--------订单处理
    Route::group(['prefix' => 'order/'], function() {
        Route::get('orderSearchPage','Admin\Order\OrderController@orderSearchPage');
        Route::get('untreatedPage','Admin\Order\OrderController@untreatedPage');
    });

    //-----无权限访问
    Route::get('Error/NotPermission','Admin\homeController@NotPermission');
    
});

Route::get('/admin/Login','Admin\homeController@login');

Route::post('/admin/Sign','Admin\homeController@toSign');

Route::get('/admin/Register','Admin\homeController@Register');
Route::post('/admin/toRegister','Admin\homeController@toRegister');

Route::post('/upload/image','Common\CommonController@uploadImage');


/******************************end*******************************************/