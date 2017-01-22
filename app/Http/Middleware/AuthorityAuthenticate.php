<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\Common\CommonService;
use Illuminate\Support\Facades\Route;

class AuthorityAuthenticate
{

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $getCurrentUser = $request->session()->get('adminusername');
        //查询绑定的角色
        $checkWhichRole = $this->commonService->checkWhereRole($getCurrentUser);
        //根据角色查询绑定的权限
        $getBindPermission   = $this->commonService->getBindPermission($checkWhichRole->id);
        //匹配路由

        $checkRouteUrl = [];
        for($i=0; $i < count($getBindPermission); $i++){
            if($this->commonService->checkRouteUrl($getBindPermission[$i])){
                $checkRouteUrl[] = $this->commonService->checkRouteUrl($getBindPermission[$i]);
            }
        }


        if($checkRouteUrl){
            return $next($request);
        }else{
            return view('Admin.Error.NotPermission');
        }

    }
}
