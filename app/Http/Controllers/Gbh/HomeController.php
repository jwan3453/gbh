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


    public function contactUs()
    {
        return view('Gbh.contactUs');
    }
    public function team()
    {
        return view('Gbh.team');
    }

    public function login()
    {
        return view('Gbh.login');
    }

    public function register()
    {
        return view('Gbh.register');
    }

    public function PageNotFound()
    {
        return view('Gbh.pageNotFound');
    }

}

?>