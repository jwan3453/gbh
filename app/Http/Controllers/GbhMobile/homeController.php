<?php
namespace App\Http\Controllers\GbhMobile;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class homeController extends Controller
{
    //
    private $user;
    private $setting;
    private $product;
    public function __construct()
    {

    }
    public function home(Request $request)
    {

        return view('GbhMobile.home');
    }
}

?>