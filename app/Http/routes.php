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

///*******************************GbhMibile*********************************************/

Route::get('mobile','GbhMobile\homeController@home');
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


///************end*****************/




/**********Gbh website***************/


Route::get('/', 'Gbh\HomeController@home');

Route::get('/newArticles', 'Gbh\HomeController@newArticles');

Route::get('/aboutUs','Gbh\HomeController@aboutUs');

Route::get('/joinUs','Gbh\HomeController@joinUs');

Route::get('/history', 'Gbh\HomeController@history');

Route::get('/contactUs','Gbh\HomeController@contactUs');

Route::get('/team','Gbh\HomeController@team');

Route::get('/booking', 'Gbh\HomeController@booking');

Route::get('/article/{articleId}', 'Gbh\ArticleController@showArticle');

Route::post('/getArticleByCate','Gbh\ArticleController@getArticleByCate');

Route::get('/gbh/login','Gbh\HomeController@login');

Route::get('/gbh/register','Gbh\HomeController@register');

Route::get('/gbh/PageNotFound','Gbh\HomeController@PageNotFound');

Route::post('/gbh/article/praise','Gbh\ArticleController@praise');

Route::post('/submitMessage','Gbh\HomeController@submitMessage');

//解析微信图片
Route::get('/resolveWeChatImg/{url?}','Gbh\HomeController@resolveWechatImage');

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



        Route::post('insertPolicy','Admin\Hotel\HotelController@insertPolicy');

        Route::post('insertContactPayment','Admin\Hotel\HotelController@insertContactPayment');

        Route::post('insertFacility','Admin\Hotel\HotelController@insertFacility');

        Route::get('createHotelError/{errorid}/{hotelId}','Admin\Hotel\HotelController@createHotelError');

        Route::post('selectUpOrDown','Admin\Hotel\HotelController@selectUpOrDown');
        Route::post('itemUpOrDown','Admin\Hotel\HotelController@itemUpOrDown');

        Route::post('deleteHotel','Admin\Hotel\HotelController@deleteHotel');
        Route::post('toTop','Admin\Hotel\HotelController@toTop');

        Route::get('editHotel/{hotelId}','Admin\Hotel\HotelController@editHotel');
        Route::get('editGeoLocation/{hotelId}','Admin\Hotel\HotelController@editGeoLocation');
        Route::get('editPaymentAndContact/{hotelId}','Admin\Hotel\HotelController@editPaymentAndContact');
        Route::get('editFacility/{hotelId}','Admin\Hotel\HotelController@editFacility');



        //管理酒店图片
        {


            Route::post('uploadImage','Admin\Hotel\HotelController@uploadImage');

            Route::post('deleteHotelImage','Admin\Hotel\HotelController@deleteHotelImage');

            Route::post('coverHotelImage','Admin\Hotel\HotelController@coverHotelImage');
        }


        //管理酒店房型
        {
            //管理房间
            Route::get('hotelInfo/{hotelId}/manageRoom', 'Admin\Hotel\HotelController@manageRoom');

            //编辑房间
            Route::get('hotelInfo/{hotelId}/editRoom/{roomId}', 'Admin\Hotel\HotelController@editRoom');

            //创建房间
            Route::post('/createNewRoom', 'Admin\Hotel\HotelController@createNewRoom');

            //更新房间
            Route::post('/updateRoom', 'Admin\Hotel\HotelController@updateRoom');

            //删除房间
            Route::post('/deleteRoom', 'Admin\Hotel\HotelController@deleteRoom');
        }

        //酒店信息维护
        {
            //基本信息Hotel
            Route::get('hotelInfo/{hotelId}/maintainHotelBasicInfo', 'Admin\Hotel\HotelController@maintainHotelBasicInfo');
            //交通信息
            Route::get('hotelInfo/{hotelId}/maintainHotelGeoInfo', 'Admin\Hotel\HotelController@maintainHotelGeoInfo');

            //提交新的周边环境(添加或修改)
            Route::post('hotelInfo/createOrUpdateSurrounding','Admin\Hotel\HotelController@createOrUpdateSurrounding');

            //删除周边环境项目
            Route::post('hotelInfo/deleteSurroundingItem','Admin\Hotel\HotelController@deleteSurroundingItem');

            //酒店政策
            Route::get('hotelInfo/{hotelId}/maintainHotelPolicy', 'Admin\Hotel\HotelController@maintainHotelPolicy');

            //提交酒店政策(添加或修改)
            Route::post('hotelInfo/createOrUpdatePolicy','Admin\Hotel\HotelController@createOrUpdatePolicy');

            //酒店联系人
            Route::get('hotelInfo/{hotelId}/maintainHotelContact','Admin\Hotel\HotelController@maintainHotelContact');

            //提交酒店联系人(添加或修改)
            Route::post('hotelInfo/createOrUpdateContact','Admin\Hotel\HotelController@createOrUpdateContact');

            //删除酒店联系人
            Route::post('hotelInfo/deleteHotelContact','Admin\Hotel\HotelController@deleteHotelContact');

            //管理酒店设施
            Route::get('hotelInfo/{hotelId}/maintainHotelFacilities','Admin\Hotel\HotelController@maintainHotelFacilities');

            //新增或修改设施清单
            Route::post('hotelInfo/createOrUpdateHotelFacilities' ,'Admin\Hotel\HotelController@createOrUpdateHotelFacilities' );


            //管理酒店餐饮服务
            Route::get('hotelInfo/{hotelId}/maintainHotelCateringService','Admin\Hotel\HotelController@maintainHotelCateringService');

            //新增或修改酒店餐饮服务项目
            Route::post('hotelInfo/createOrUpdateHotelCateringItem' ,'Admin\Hotel\HotelController@createOrUpdateHotelCateringItem' );

            //删除酒店餐饮服务项目
            Route::post('hotelInfo/deleteHotelCateringItem','Admin\Hotel\HotelController@deleteHotelCateringItem');

            //管理酒店健身娱乐服务
            Route::get('hotelInfo/{hotelId}/maintainHotelRecreationService','Admin\Hotel\HotelController@maintainHotelRecreationService');

            //新增或修改酒店健身娱乐项目
            Route::post('hotelInfo/createOrUpdateHotelRecreationItem' ,'Admin\Hotel\HotelController@createOrUpdateHotelRecreationItem' );

            //删除酒店健身娱乐项目
            Route::post('hotelInfo/deleteHotelRecreationItem','Admin\Hotel\HotelController@deleteHotelRecreationItem');


            //管理酒店图片
            Route::get('hotelInfo/{hotelId}/maintainHotelImage','Admin\Hotel\HotelController@maintainHotelImage');

            //上传酒店图片
            Route::post('hotelInfo/uploadHotelImage','Admin\Hotel\HotelController@uploadHotelImage');

            //删除酒店图片
            Route::post('hotelInfo/deleteHotelImage','Admin\Hotel\HotelController@deleteHotelImage');

            //获取酒店区域照片
            Route::post('hotelInfo/getSectionImage','Admin\Hotel\HotelController@getSectionImage');

            //设计酒店外网封面图片
            Route::post('hotelInfo/setHotelCoverImage','Admin\Hotel\HotelController@setHotelCoverImage');

            //取消酒店外网封面图片
            Route::post('hotelInfo/cancelHotelCoverImage','Admin\Hotel\HotelController@cancelHotelCoverImage');


            //取消酒店外网封面图片
            Route::post('hotelInfo/getHotelCoverImage','Admin\Hotel\HotelController@getHotelCoverImage');

            //设计酒店外网首张图片
            Route::post('hotelInfo/setHotelFirstImage','Admin\Hotel\HotelController@setHotelFirstImage');


        }

    });




    //管理房态
    Route::group(['prefix' => 'manageRoomStatus/'], function() {

        //酒店列表
        Route::get('/', 'Admin\Hotel\HotelController@manageRoomStatus');

        //编辑跟新酒店房态
        Route::get('/show/{hotelId}', 'Admin\Hotel\HotelController@showRoomStatus');



        //搜索酒店房态
        Route::post('/searchRoomStatus', 'Admin\Hotel\HotelController@showRoomStatus');


        //批量修改房态
        Route::get('/roomStatusBatch/{hotelId}', 'Admin\Hotel\HotelController@roomStatusBatch');

        //提交单次房态修改请求
        Route::post('/roomStatusUpdateSubmit','Admin\Hotel\HotelController@roomStatusUpdateSubmit');

        //提交批量修改的房态
        Route::post('/roomStatusBatchRequestSubmit','Admin\Hotel\HotelController@roomStatusBatchRequestSubmit');

        //查看房态批量修改记录
        Route::get('/roomStatusBatchLog/{hotelId}','Admin\Hotel\HotelController@roomStatusBatchLog');

    });


    //管理房价
    Route::group(['prefix' => 'manageRoomPrice/'], function() {

        //酒店列表
        Route::get('/', 'Admin\Hotel\HotelController@manageRoomPrice');

        //查看酒店房态
        Route::get('/show/{hotelId}', 'Admin\Hotel\HotelController@showRoomPrice');

        //搜索酒店房态
        Route::post('/searchRoomPrice', 'Admin\Hotel\HotelController@showRoomPrice');


        //批量修改房价
        Route::get('/roomPriceBatch/{hotelId}', 'Admin\Hotel\HotelController@roomPriceBatch');

        //提交单次房价修改请求
        Route::post('/roomPriceUpdateSubmit','Admin\Hotel\HotelController@roomPriceUpdateSubmit');

        //提交批量修改的房价
        Route::post('/roomPriceBatchRequestSubmit','Admin\Hotel\HotelController@roomPriceBatchRequestSubmit');

        //处理批量修改房价申请单
        Route::get('/processRoomPriceRequest/{hotelId}','Admin\Hotel\HotelController@processRoomPriceRequest');

        //确定房价申请单
        Route::post('/confirmRoomPriceRequest','Admin\Hotel\HotelController@confirmRoomPriceRequest');
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

    //设置目的地信息
    Route::get('system/manageDestination','Admin\System\SystemController@manageDestination');

    //获取目的地信息
    Route::post('system/getDestinationInfo','Admin\System\SystemController@getDestinationInfo');

    //保存目的地信息
    Route::post('system/saveDestinationInfo','Admin\System\SystemController@saveDestinationInfo');


    //设置酒店分类
    Route::get('system/manageHotelCategory','Admin\System\SystemController@manageHotelCategory');

    //保存分类
    Route::post('system/saveHotelCategory','Admin\System\SystemController@saveHotelCategory');

    //删除分类
    Route::post('system/deleteHotelCategory','Admin\System\SystemController@deleteHotelCategory');



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


    //超级管理员
    Route::group(['prefix' => 'administrator/'], function() {

        //Route::get('manageRoomPriceRequest','Admin\Hotel\HotelController@manageRoomPriceRequest');




    });


    
});

Route::get('/admin/Login','Admin\homeController@login');

Route::post('/admin/Sign','Admin\homeController@toSign');

Route::get('/admin/Register','Admin\homeController@Register');
Route::post('/admin/toRegister','Admin\homeController@toRegister');

Route::post('/upload/image','Common\CommonController@uploadImage');


/******************************end*******************************************/


Route::get('/jacky',function(){
    return view('PersonCV.Jacky');
});