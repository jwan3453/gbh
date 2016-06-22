<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Admin\AdminUserService;

use App\Tool\MessageResult;

class HomeController extends Controller
{

    private $adminUser;

    function __construct(AdminUserService $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('Admin.home');
    }

    public function login()
    {
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
                $request->session()->put('adminusername',$adminInfo->username);
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
