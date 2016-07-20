<?php
namespace App\Http\Controllers\Gbh;
use App\Tool\MessageResult;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Gbh\ArticleService;
use App\Service\Gbh\SlideService;
Use Illuminate\Support\Facades\Mail;

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

    public function booking()
    {
        return view('Gbh.booking');
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

    public function submitMessage(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $homeMessage = $request->input('message');
        $toEmail='jackywang@gbhchina.com';
        //把消息发送到公司邮箱


        $data = ['name'=>$name, 'email'=>$email, 'homeMessage'=>$homeMessage, 'toEmail'=>$toEmail];
        Mail::send('emails.contactMessage', $data, function ($message) use ($data) {
            $message->from('jackywang@gbhchina.com');
            $message->to($data['toEmail'])->subject('来自gbhchina.com提交的信息');
        });

        $jsonResult = new MessageResult();
        $jsonResult->statusCode = 1;
        $jsonResult->statusMsg ='邮件发送成功';
        return response($jsonResult->toJson());

    }
}

?>