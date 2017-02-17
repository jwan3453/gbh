<?php

namespace App\Http\Controllers\Admin\Role;

use App\Service\Common\CommonService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tool\MessageResult;
use App\Http\Controllers\Controller;
use App\Service\Admin\RoleService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


class RoleManagerController extends Controller
{
    private $adminRole;

    private $commonService;

    function __construct(RoleService $adminRole,CommonService $commonService)
    {

        $this->adminRole = $adminRole;
        $this->commonService = $commonService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){

        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    //用户管理
    public function show()
    {
        $name = Route::current();
        //是否有权限
        $getSession = Session::get('adminusername');

        if($getSession){

            //获取路由
            $currentUrl    = $this->commonService->getCurrentUrl();

            $getMenuName   = $this->commonService->getMenuName($currentUrl);
            //父级菜单
            $firstMenuName = $this->commonService->firstMenuName($getMenuName);

            $dataRes   =   $this->adminRole->userData();          //用户数据
            $countRes  =   $this->adminRole->countData();         //用户数量
            $roleRes   =   $this->adminRole->roleData();          //角色数据
            $hotelRes  =   $this->adminRole->hotelData();         //酒店数据

            return view('Admin.Role.userManager',compact('dataRes','roleRes','hotelRes'),['pageNum' => $dataRes])->with(['countRes'=> $countRes,'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);

        }
    }


    //角色组管理
    public function showRole(){

        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        $roleRes  = $this->adminRole->roleData();       //用户组数据
        $countRes = $this->adminRole->countRole();      //组数量

        return view('Admin.Role.roleGroupManager',compact('roleRes'))->with(['countRes'=> $countRes,'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);

    }

    //权限管理
    public function showPermission(){

        //--------Menu
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        //--------Permission
        $permissionRes = $this->adminRole->permissionData();
        //--------Menu
        $getFirstMenu       = $this->adminRole->getMenuData();
        $getSecondMenu      = $this->adminRole->getSecondMenu();


        return view('Admin.Role.permissionManager',compact('getFirstMenu',$getFirstMenu),compact('getSecondMenu' , $getSecondMenu))->with(['permissionRes' => $permissionRes,'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);

    }

    //权限分配
    public function permissionAssignment(){


        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        $roleRes = $this->adminRole->roleData();     //角色组数据
        //菜单数据
        $firstMenuInfo = $this->adminRole->firstMenuInfo();

        return view('Admin.Role.permissionAssignment',compact('roleRes','firstMenuInfo'))->with(['getMenuName' => $getMenuName,'firstMenuName' => $firstMenuName]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //检查用户名重复性
    public function checkNewUser(){

        $checkRes   = $this->adminRole->checkUser();
        $jsonResult = new MessageResult();
        if($checkRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "重复";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "无重复";

        }

        return response($jsonResult->toJson());

    }

    //检查编辑用户名的重复性
    public function checkEditUser(){

        $checkRes   = $this->adminRole->editUsername();
        $jsonResult = new MessageResult();
        if($checkRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "重复";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "无重复";

        }

        return response($jsonResult->toJson());

    }

    //检查角色重复性
    public function checkNewRole(){

        $checkRes   = $this->adminRole->checkRole();
        $jsonResult = new MessageResult();

        if($checkRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "重复";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "无重复";

        }

        return response($jsonResult->toJson());

    }

    //检查除某角色以外的重复性
    public function checkEditRole(){

        $checkRes   = $this->adminRole->editRole();
        $jsonResult = new MessageResult();

        if($checkRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "角色名重复";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "无重复";

        }

        return response($jsonResult->toJson());

    }


    //检查权限重复性
    public function checkNewPermissions(){

        $checkRes   = $this->adminRole->checkPermissions();
        $jsonResult = new MessageResult();

        if($checkRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "重复";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "无重复";

        }

        return response($jsonResult->toJson());

    }
    //检查除某权限以外的重复性
    public function checkEditPermissions(){

        $checkRes   = $this->adminRole->editPermissions();
        $jsonResult = new MessageResult();

        if($checkRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "重复";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "无重复";

        }

        return response($jsonResult->toJson());

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //新增用户
    public function createUser()
    {
        $createRes  = $this->adminRole->addUser();
        $jsonResult = new MessageResult();

        if($createRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());
    }


    //新增角色
    public function createRole(){

        $createRes  = $this->adminRole->addRole();
        $jsonResult = new MessageResult();

        if($createRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    //新增权限
    public function createPermissions(){

        $createRes  = $this->adminRole->addPermissions();
        $jsonResult = new MessageResult();

        if($createRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //获得数据
    public function detailUser()
    {
        $getRes = $this->adminRole->getUser();

        if($getRes){

            $resultjson = new MessageResult();
            $resultjson->extra =  $getRes;

            return response($resultjson->toJson());
        }
    }


    public function detailRole(){

        $detailRes = $this->adminRole->getRole();

        if($detailRes){

            $resultjson = new MessageResult();
            $resultjson->extra =  $detailRes;

            return response($resultjson->toJson());

        }

    }

    public function detailHasUser(){

        $currentUser = $this->adminRole->getRole();

        $hasUser     = $this->adminRole->hasUser();

        $resultjson  = new MessageResult();

        $userList = "";

        for($i=0; $i < count($hasUser); $i++){

            $userList .= $hasUser[$i]->username.",";
            $resultjson->extra      =  $userList;
            $resultjson->statusMsg  =  $currentUser;
        }

        return response($resultjson->toJson());


    }


    public function detailPermissions(){

        $detailRes    = $this->adminRole->getPermissions();

        if($detailRes){

            $resultjson = new MessageResult();
            if($detailRes->parent_id){
                //存在绑定权限组
                $resultjson->statusMsg = $detailRes->parent_id;
                $resultjson->extra =  $detailRes;

            }elseif(!$detailRes->parent_id){
                $resultjson->statusMsg = null;
                $resultjson->extra =  $detailRes;
            }

            return response($resultjson->toJson());

        }

    }


    public function detailCurrentBind(){

        $getRes = $this->adminRole->getUser();
        if($getRes){

            //判断当前角色组
            $user_id = $_POST['id'];

            $hasRole = $this->adminRole->hasRole($user_id);


            $resultjson = new MessageResult();
            if($hasRole){
                //获取当前绑定的角色组
                $bindRole = $this->adminRole->currentRoleInfo($user_id);

                $resultjson->extra     =  $getRes;
                $resultjson->statusMsg = $bindRole;


            }else{
                $resultjson->extra =  $getRes;

            }

            return response($resultjson->toJson());
        }



    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser()
    {
        $storeRes   = $this->adminRole->storeUser();
        //绑定角色

        $jsonResult = new MessageResult();

        if($storeRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    //编辑存储角色
    public function updateRole(Request $request){

        $storeRes   = $this->adminRole->storeRole($request);

        $jsonResult = new MessageResult();

        if($storeRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    public function updatePermissions(){

        $storeRes   = $this->adminRole->storePermissions();
        $jsonResult = new MessageResult();

        if($storeRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser()
    {
        //是否绑定角色组
        $hasBindGroup = $this->adminRole->IsHasBindGroup();
        $jsonResult = new MessageResult();
        if($hasBindGroup->user_id != $_POST['userId']){
            $removeRes  = $this->adminRole->removeUser();
            if($removeRes){

                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg  = "成功";

            }else{

                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg  = "失败";

            }
        }else{
            $this->adminRole->removeHasBingRole();
            $removeRes  = $this->adminRole->removeUser();
            if($removeRes){

                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg  = "成功";

            }else{

                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg  = "失败";

            }
        }


        return response($jsonResult->toJson());
    }


    public function deleteRole(){

        //是否含有组员
        $bindGroup = $this->adminRole->IsHasGroup();
        $jsonResult = new MessageResult();
        if($bindGroup == NULL || $bindGroup->role_id != $_POST['roleId']){
            $deleteRes  = $this->adminRole->removeRole();
            if($deleteRes){

                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg  = "成功";

            }else{

                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg  = "失败";

            }
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";
        }


        return response($jsonResult->toJson());

    }


    public function deletePermissions(){

        //是否有绑定权限
        $bindPermission = $this->adminRole->IsHasPermission();
        $jsonResult = new MessageResult();
        if($bindPermission == NULL || $bindPermission->permission_id != $_POST['id']){
            $deleteRes  = $this->adminRole->removePermissions();

            if($deleteRes){
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg  = "成功";
            }else{
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg  = "失败";
            }

        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";
        }

        return response($jsonResult->toJson());

    }

    //移除绑定的权限
    public function removeAlreadyPerm(){

        $deleteRes = $this->adminRole->deletePerm();

        $jsonResult = new MessageResult();

        if($deleteRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

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

    //分配权限
    public function assignPermissions($id){

        //获取路由
        $currentUrl    = '/admin/administrator/permissionassignment';
        $this->commonService->putSession($currentUrl);
        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        $detailRole         =   $this->adminRole->detailRole($id);           //角色信息

        //-----permission
        $permissions        =   $this->adminRole->permissionData();            //权限列表

        $currentPermission  =  $this->adminRole->currentPerm($id);          //当前拥有权限

        return view('Admin.Role.settingPermissions',compact('detailRole','currentPermission'))->with(['permissions' => $permissions,'getMenuName' => $getMenuName,'firstMenuName' => $firstMenuName]);


    }

    //设置权限
    public function settingPermissions(Request $request){

        $setRes     = $this->adminRole->settingPermission($request);

        $jsonResult = new MessageResult();

        if($setRes){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "成功";

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    //分配角色
    public function bindingRole(Request $request){

        $choiceRes = $this->adminRole->bindingRole($request);

        return $choiceRes;

    }

    //判断权限类型
    public function permType(){

        $getPermList = $this->adminRole->typePermList();
        $permId   = [];
        $permName = [];
        for($i = 0; $i < count($getPermList) ; $i++){
            $permId[]   = $getPermList[$i]->id;
            $permName[] = $getPermList[$i]->display_name;
        }

        $jsonResult = new MessageResult();

        if($getPermList){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = $permId;
            $jsonResult->extra      = $permName;

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    public function permTypeForEdit(){

        $getPermList = $this->adminRole->typePermList();
        $permId   = [];
        $permName = [];
        for($i = 0; $i < count($getPermList) ; $i++){
            $permId[]   = $getPermList[$i]->id;
            $permName[] = $getPermList[$i]->display_name;
        }

        $jsonResult = new MessageResult();

        if($getPermList){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = $permId;
            $jsonResult->extra      = $permName;

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());

    }

    public function menuTypeForEdit(){

        $getMenuList = $this->adminRole->typeMenuList();
        $menuId   = [];
        $menuName = [];
        for($i = 0; $i < count($getMenuList) ; $i++){
            $menuId[]   = $getMenuList[$i]->id;
            $menuName[] = $getMenuList[$i]->menu_name;
        }

        $jsonResult = new MessageResult();

        if($getMenuList){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = $menuId;
            $jsonResult->extra      = $menuName;

        }else{

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "失败";

        }

        return response($jsonResult->toJson());


    }


}
