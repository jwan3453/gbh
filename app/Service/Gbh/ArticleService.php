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
        $article = Article::findOrfail($articleId);
        if($article != null)
        {
            $count = Article::where('id',$articleId)->select('view_count')->first()->view_count;
            $view_count = $count + 1;
            Article::where('id',$articleId)->update(['view_count'=>$view_count]);
        }
        return $article;
    }

    public function getHomeArticleList()
    {
        $articleList[] ='';
        $articleCategories = ArticleCategory::all();
        foreach($articleCategories as $articleCategory)
        {
            $articleList[$articleCategory->category_name] = Article::where(['category'=>$articleCategory->id,'is_draft'=>0])->orderBy('published_at','desc')->take(6)->select('id','title','author','brief','cover_image')->get();
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
        $articles['article'] = Article::select('category','id','title','author','brief','cover_image','view_count','praise','published_at')->orderby('published_at','desc')->get();
        $articles['category'] = ArticleCategory::all();

        foreach( $articles['article'] as $article)
        {
            foreach(  $articles['category']  as $category)
            {

                if($article->category == $category->id)
                {

                    $article->category_name = $category->category_name;
                }
            }

        }

        return $articles;

    }

    public function getArticleByCate($category)
    {

        $articles = Article::where('is_draft',0)->select('category','id','title','author','brief','cover_image','published_at')->orderby('published_at','desc')->get();
        $articleCategories = ArticleCategory::all();
        if($category != 0 )
        {
            $articles = Article::where('category',$category)->select('category','id','title','author','brief','cover_image','view_count','praise','published_at')->orderby('published_at','desc')->get();
        }
        else{
            $articles = Article::select('category','id','title','author','brief','cover_image','view_count','praise','published_at')->orderby('published_at','desc')->get();
        }

        foreach( $articles as $article)
        {
            foreach(  $articleCategories  as $category)
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