<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Admin\AdminUserService;
use App\Tool\MessageResult;
use App\Service\Common\CommonService;


class HomeController extends Controller
{

    private $adminUser;

    private $commonService;

    function __construct(AdminUserService $adminUser,CommonService $commonService)
    {

        $this->adminUser = $adminUser;
        $this->commonService = $commonService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //获得用户
        $getCurrentUser  =  $request->session()->get('adminusername');
        //查询所在的角色组
        $checkWhereRole  =  $this->commonService->checkWhereRole($getCurrentUser);

        //获得该组的权限
        $getPermission   =  $this->commonService->getPermissions($checkWhereRole->id);

        //菜单Info
        $getMenuId       =  $this->commonService->getMenuInfo();


        //--------menuList
        $menuStr = "";
        for($i=0; $i < count($getMenuId); $i++){
            $menuStr .= $getMenuId[$i]->permission_id;
        }
        static  $pos = 0;
        $sub = substr($menuStr,$pos,2);
        $curstr = $sub;
        function subToStr($sub,$pos,$menuStr,$curstr){

            if($sub > 10){
                $pos += 2;
                $sub = substr($menuStr,$pos,2);
                $curstr .= $sub;

                subToStr($sub,$pos,$menuStr,$curstr);
                return $curstr;

            }elseif($sub = 10){
                return $sub;
            }

        }
        $strtostr     =   subToStr($sub,$pos,$menuStr,$curstr);
        $prevstr      =   "";
        $prevstr     .=   $strtostr;                     //大于10的字符串
        $prevarr      =   str_split($prevstr,2);


        $lastMenu     =   substr($menuStr,$pos+2,count($getMenuId)-count($prevstr));     //剩下的字符串
        $lastMenuList =   str_split($lastMenu,1);


        //--------permissionList
        $perStr = "";
        for( $i=0; $i < count($getPermission); $i++){
            $perStr  .= $getPermission[$i]->permission_id;
        }
        $perStrs   = substr($perStr,6,2);
        $lastPrems = substr($perStr,0,6);              //剩下的字符串

        //查找匹配字符串(数组)
        $menuForPerms = "";
        for($i = 0; $i < count($lastMenuList); $i++){
            $resSearch = strpos($lastPrems,$lastMenu[$i],0);
            if($resSearch){
                $menuForPerms .= substr($lastMenu,$resSearch,1);
            }
        }
        $menuForPermsArray  = str_split($menuForPerms,1);


        if($perStrs == $prevstr){
            array_unshift($menuForPermsArray,$prevarr[0]);
        }


        //查询菜单

        for( $k=0; $k < count($menuForPermsArray); $k++){
            $allMenuLists = $this->adminUser->loadMenuList($menuForPermsArray[$k]);

        }
        return view('Admin.home',compact('allMenuLists'));


    }

    public function login()
    {
        return view('Admin.Sign.sign');
    }

    public function logout(Request $request){

        setcookie('adminusername','test3',time()+3600*10);
        $request->session()->forget('adminusername');
        return view('Admin.Sign.sign');

    }

    public function toSign(Request $request)
    {
        
        $resultjson = new MessageResult();

        $adminSuccess = false;

        if ($request->input('username') != '' || $request->input('password') != '') {
            $adminUser = $this->adminUser->isAdmin($request->input());

            if ($adminUser) {
                $adminInfo = $this->adminUser->getAdminInfo($request->input('username'));
                $request->session()->forget('adminusername');
                $request->session()->put('adminusername',$adminInfo->username);
                setcookie('adminusername',$request->input('username'),time()+3600*60);
                $request->session()->put('adminstatus',$adminInfo->admin_level);
                $request->session()->put('adminid',$adminInfo->id);
                $request->session()->put('permission',$adminInfo->permission);
                $adminSuccess = true;
            }
        }

        if ($adminSuccess) {
            $resultjson->status = 1;
            $resultjson->Msg = "验证成功！";
        }else{
            $resultjson->status = 0;
            $resultjson->Msg = "验证失败！";
        }

        return response($resultjson->toJson());
    }

    public function NotPermission($value='')
    {
        return view('Admin.Error.NotPermission');
    }

    public function Register()
    {
        return view('Admin.Sign.Register');
    }

    public function toRegister(Request $request)
    {
        $resultjson = new MessageResult();
        
        $adminSuccess = $this->adminUser->toRegister($request->input());

        if ($adminSuccess) {
            $resultjson->status = 1;
            $resultjson->Msg = "验证成功！";
        }else{
            $resultjson->status = 0;
            $resultjson->Msg = "验证失败！";
        }

        return response($resultjson->toJson());
    }


    public function checkAdminUser(Request $request){

        $checkAdminUser = $this->commonService->checkAdminUser($request);
        $resultjson = new MessageResult();

        if ($checkAdminUser) {
            $resultjson->status = 1;
            $resultjson->Msg = "验证成功！";
        }else{
            $resultjson->status = 0;
            $resultjson->Msg = "验证失败！";
        }

        return response($resultjson->toJson());

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
