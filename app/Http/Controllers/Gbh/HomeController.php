<?php
namespace App\Http\Controllers\Gbh;
use App\Tool\MessageResult;
use App\Union;
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
//新增加入联盟模块
    public function hotelUnion(){
        return view('Gbh.hotelUnion');
    }
    public function joinUnion(Request $request){

        if($request->isMethod('POST')){

            $union = $request->input('Union');
//            dd($union['person_email']);

            if(Union::create($union)){
                //邮箱发送
                $toEmail = $union['person_email'];
                $Message = "您好,我们已经收到您的联盟信息,感谢您对我们的信任.请耐心等待我们的工作人员与您取得联系";

                $data = ['email'=>$toEmail, 'Message'=>$Message];
//
                Mail::raw($data['Message'],function($message) use ($data){
                    $message->from('booking@gbhchina.com');
                    $message->to($data['email'])->subject('来自gbhchina.com提交的申请联盟');
                });

                return view('Gbh.joinUnion');
            }else{
                return redirect()->back();
            }
        }
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
    public function resolveWechatImage(Request $request)
    {

        $img= file_get_contents( $request->input('url'));
        return $img;
    }

}

?>