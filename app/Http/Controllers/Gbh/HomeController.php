<?php
namespace App\Http\Controllers\Gbh;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Gbh\ArticleService;
use App\Service\Gbh\SlideService;

class HomeController extends Controller
{
    //

    private $article;
    private $slide;
    public function __construct( ArticleService $article ,SlideService $slide){
        $this->article = $article ;
        $this->slide = $slide;
    }   

    public function home(Request $request)
    {


        $articleList = $this->article->getHomeArticleList();
        $slideList = $this->slide->getSlideList();
        return view('Gbh.home')->with('articleList',$articleList)->with('slideList',$slideList);
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