<?php

namespace App\Http\Controllers\Admin\Menu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Admin\MenuSettingService;

use App\Tool\MessageResult;

class MenuSettingController extends Controller
{


    private $menuSetting;
    public function __construct(MenuSettingService $menuSetting ){

        $this->menuSetting = $menuSetting ;
    }

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $is = $this->isRolePermission("all");
        // if (!$is) {
        //     return redirect(url('admin/Error/NotPermission'));
        // }

        $menuList = $this->menuSetting->getOneMenu();
        // dd($menuList);
        return view('Admin.Menu.menuSetting')->with('menuList',$menuList);
    }

    public function getSecondMenu(Request $request)
    {
        $jsonResult = new MessageResult();

        $jsonResult->getSecondMenu = $this->menuSetting->getSecondMenu($request->input('menuId'));

        return response($jsonResult->toJson());
    }

    public function createMenu(Request $request)
    {
        $jsonResult = new MessageResult();

        $formData = $request->input('form');


        $createMenu = $this->menuSetting->createOrUpdateMenu($request->input());

        if ($createMenu) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());

    }

    public function uploadIcon(Request $request)
    {   
        $file = $_FILES[$request->input('filename')];

        return $this->menuSetting->uploadIcon($file,$request->input('menuLevel'));

    }

    public function getMenuInfo(Request $request)
    {
        return $this->menuSetting->getMenuInfoById($request->input('menuId'));
    }

    public function menuDelete(Request $request)
    {
        return $this->menuSetting->menuDelete($request->input('menuId'));
    }

    public function getFirstMenu()
    {
        return $menuList = $this->menuSetting->getOneMenu();
    }

    
}
