<?php
namespace App\Http\Controllers\Gbh;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Gbh\ArticleService;

use App\Tool\MessageResult;


class ArticleController extends Controller
{
    //

    private $article;
    public function __construct( ArticleService $article){
        $this->article = $article ;

    }
    public function showArticle($articleId)
    {

        $article= $this->article->showArticle($articleId);
        if(!empty($article->wechat_url))
        {
            $article->wechat_content = file_get_contents($article->wechat_url);
            $article->wechat_content= str_replace('mmbiz.qpic.cn','o6kyd0ndv.qnssl.com', $article->wechat_content);


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