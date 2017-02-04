<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 16/12/27
 * Time: 上午9:08
 */



namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Closure;
use Illuminate\Support\Facades\Session;

class DirectionPathSession{

    public function handle(Request $request,Closure $next){


        session(['currentPath_'=>$request->getPathInfo()]);

        return $next($request);

    }


}