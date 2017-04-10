<?php
namespace App\Http\Controllers\Gbh;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Gbh\ArticleService;

use App\Tool\MessageResult;
use Illuminate\Support\Facades\Redis;


class ArticleController extends Controller
{
    //

    private $article;
    public function __construct( ArticleService $article){
        $this->article = $article ;

    }
    public function showArticle($articleId)
    {


      //  $sortedViews = Redis::zRevRange('articleViews',0,-1,'withscores');


        $article= $this->article->showArticle($articleId);
        if(!empty($article->wechat_url))
        {
            //从微信连接获取文章html
            $article->wechat_content = file_get_contents($article->wechat_url);

            //传送门解析微信图片
            $article->wechat_content= str_replace('http://mmbiz.qpic.cn','http://gbhchina.com/resolveWeChatImg?url=http://mmbiz.qpic.cn',
                                      $article->wechat_content);

            $article->wechat_content = str_replace('data-src','src',
                                     $article->wechat_content);

            //强制anchor为白色
            $article->wechat_content =str_replace('#607fa6','#f8f8f8', $article->wechat_content);


            //浏览计数 储存在redis
            //$views = Redis::zIncrBy('articleViews',1,'article:'.$articleId);


         //   dd($article->wechat_content);
        }
        if($article == null)
        {
            return view('Gbh.pageNotFound');
        }
        return view('Gbh.article')->with('article',$article);
    }

    public function praise(Request $request)
    {
        $jsonResult = new MessageResult();
        
        $praise = $this->article->toPraise($request->input('articleId'));
        
        if ($praise) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function getArticleByCate(Request $request)
    {
        $jsonResult = new MessageResult();
        $articles = $this->article->getArticleByCate($request->input('category'));

        $jsonResult->statusCode = 1;
        $jsonResult->statusMsg = "成功";
        $jsonResult->extra = $articles;
        return response($jsonResult->toJson());

    }


}

?>