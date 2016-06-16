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
}



?>