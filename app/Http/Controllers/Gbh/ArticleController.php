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
        if($article == null)
        {

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

}

?>