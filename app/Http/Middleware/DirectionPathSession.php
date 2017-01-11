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

class DirectionPathSession extends StartSession{


    //这里要使用StartSession才能将值存入


}