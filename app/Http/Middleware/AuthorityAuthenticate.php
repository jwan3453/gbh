<?php

namespace App\Http\Middleware;

use Closure;
use App\Service\Common\CommonService;

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
        $userInfo       = $this->commonService->checkInUser($getCurrentUser);

        $checkIsRole    = $this->commonService->checkIsRole($userInfo);

        if($checkIsRole){
            return $next($request);
        }else{
            return view('Admin.Error.NotPermission');
        }

    }
}
