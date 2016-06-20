<?php
namespace App\Http\Controllers\Gbh;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Gbh\ArticleService;


class HomeController extends Controller
{
    //

    private $article;
    public function __construct( ArticleService $article){
        $this->article = $article ;

    }

    public function home(Request $request)
    {


        $articleList = $this->article->getHomeArticleList();
        return view('Gbh.home')->with('articleList',$articleList);
    }


    public function newArticles()
    {
        $newArticles = $this->article->getNewArticleList();
        return view('Gbh.newArticles')->with('newArticles',$newArticles);;
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