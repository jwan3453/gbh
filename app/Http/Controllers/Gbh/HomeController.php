<?php
namespace App\Http\Controllers\Gbh;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    //

    public function __construct()
    {

    }
    public function home(Request $request)
    {

        return view('Gbh.home');
    }


    public function aboutUs(Request $request)
    {
        return view('Gbh.aboutUs');
    }


    public function joinUs(Request $request)
    {
        return view('Gbh.joinUs');
    }
    public function history(Request $request)
    {
        return view('Gbh.history');
    }

}

?>