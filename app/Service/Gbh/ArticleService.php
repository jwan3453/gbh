<?php

namespace App\Service\Gbh;


use App\Models\ArticleCategory;
use App\Models\Article;

use Carbon\Carbon;

use App\Tool\MessageResult;

/**
 *
 */
class ArticleService {

    public function showArticle($articleId)
    {
        $count = Article::where('id',$articleId)->select('view_count')->first()->view_count;
        $view_count = $count + 1;
        Article::where('id',$articleId)->update(['view_count'=>$view_count]);
        return Article::find($articleId);
    }

    public function getHomeArticleList()
    {
        $articleList[] ='';
        $articleCategories = ArticleCategory::all();
        foreach($articleCategories as $articleCategory)
        {
            $articleList[$articleCategory->category_name] = Article::where('category',$articleCategory->id)
                                                                    ->orderBy('published_at','desc')->take(6)->select('id','title','author','brief','cover_image')->get();
        }

        return $articleList;
    }


    public function toPraise($articleId)
    {
        $praise = Article::where('id', $articleId)->select('praise')->first()->praise;
        $praiseCount = $praise + 1;
        return Article::where('id', $articleId)->update(['praise' => $praiseCount]);
    }

    public function getNewArticleList()
    {
        $articles = Article::select('category','id','title','author','brief','cover_image','published_at')->get();
        $articleCategories = ArticleCategory::all();

        foreach( $articles as $article)
        {
            foreach( $articleCategories as $category)
            {

                if($article->category == $category->id)
                {

                    $article->category_name = $category->category_name;
                }
            }

        }

        return $articles;

    }
}



?>