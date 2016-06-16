<?php
namespace App\Http\Controllers\Gbh;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Gbh\ArticleService;


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

}

?>