<?php

namespace App\Http\Controllers\Admin\Article;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Admin\ArticleService;

use App\Models\Article;
use App\Models\ArticleCategory;

use App\Tool\MessageResult;
use Illuminate\Support\Facades\Session;
use App\Service\Common\CommonService;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private $article;

    private $commonService;

    public function __construct( ArticleService $article,CommonService $commonService){
        $this->article = $article ;
        $this->commonService = $commonService;


    }

    public function index()
    {

        //判断权限
        $getCurrentUser = Session::get('adminusername');
        //查询用户
        $userInfo       = $this->commonService->checkInUser($getCurrentUser);

        if($userInfo){

            //获取路由
            $currentUrl    = $this->commonService->getCurrentUrl();

            $getMenuName   = $this->commonService->getMenuName($currentUrl);
            //父级菜单
            $firstMenuName = $this->commonService->firstMenuName($getMenuName);

            //查询有无权限
            $checkIsPerm = $this->commonService->checkIsPermArticle($userInfo);

            if($checkIsPerm){
                $articles = $this->article->getArticles();

                return view('Admin.Article.manageArticle')->with(['articles' => $articles , 'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);
            }else{
                return redirect(url('admin/Error/NotPermission'));
            }

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createArticle()
    {

        //AddressSession
        Session::put('currentPath_','/admin/manageArticle');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '添加文章';

        $article = new Article();
        $articleCategories = ArticleCategory::all();

        return view('Admin.Article.createArticle')->with(['article'  => $article , 'articleCategories' => $articleCategories, 'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
        //
    }

    public function classificationandtag()
    {
        Session::put('currentPath_','/admin/manageArticle');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '文章分类管理';

        $tagNameList = $this->article->getAllArticleTag();
        $categoryList = $this->article->getAllArticleCategory();

        $oneLevelCategoryList = $this->article->getOneLevelCategory();

        return view('Admin.Article.ClassificationAndTag')->with(['tagNameList' => $tagNameList , 'categoryList' => $categoryList , 'oneLevelCategoryList' => $oneLevelCategoryList ,'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    public function addArticleTag(Request $request)
    {
        $jsonResult = new MessageResult();

        $del = $this->article->addArticleTag($request->input('tag_name'));

        if ($del) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
            $jsonResult->tagName = $request->input('tag_name');
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }


        return response($jsonResult->toJson());
    }

    public function delArticleTag(Request $request)
    {
        $jsonResult = new MessageResult();

        $addTag = $this->article->delArticleTag($request->input('tag_id'));

        if ($addTag) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function classificationOperate(Request $request)
    {
        $jsonResult = new MessageResult();

        $createMenu = $this->article->classificationOperate($request->input());

        if ($createMenu) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delArticleCategory(Request $request)
    {
        $jsonResult = new MessageResult();

        $del = $this->article->delArticleCategory($request->input('categoryId'));

        if ($del) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeArticle(Request $request)
    {


        if($this->article->storeArticle($request))
            return redirect('/admin/manageArticle');
        else{
            //返回表单提交的页面 并带有错误提示
            return  redirect('/AdminCenter');
        }
        // return view('Admin.Article.createArticle');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editArticle($articleId)
    {

        Session::put('currentPath_','/admin/manageArticle');

        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '编辑文章';
        $articleCategories = ArticleCategory::all();
        $article = $this->article->getArticle($articleId);
        return view('Admin.Article.editArticle')->with('article',$article)->with(['articleCategories' => $articleCategories , 'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateArticle(Request $request, $articleId)
    {
        if($this->article->updateArticle($request,$articleId))
            return redirect('/article/'.$articleId);
        else {
            //返回表单提交的页面 并带有错误提示
            return redirect('/AdminCenter');
        }

    }

    public function articleOnline(Request $request)
    {
        $jsonResult = new MessageResult();

        $online = $this->article->articleOnline($request->input('articleId'));

        if ($online) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function articleOffline(Request $request)
    {
        $jsonResult = new MessageResult();

        $online = $this->article->articleOffline($request->input('articleId'));

        if ($online) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delArticle(Request $request)
    {
        $jsonResult = new MessageResult();

        $online = $this->article->delArticle($request->input('articleId'));

        if ($online) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function articleToTop(Request $request)
    {
        $jsonResult = new MessageResult();

        $toTop = $this->article->articleToTop($request->input('articleId'));

        if ($toTop) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function articleCancelTop(Request $request)
    {
        $jsonResult = new MessageResult();

        $cancelTop = $this->article->articleCancelTop($request->input('articleId'));

        if ($cancelTop) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
