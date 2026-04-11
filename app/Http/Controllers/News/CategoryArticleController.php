<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Models\CategoryArticleModel;
use App\Models\ArticleModel;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Locale;

class CategoryArticleController extends LocaleController
{
    private $pathViewController  = 'news.pages.category_article.';
    private $controllerName      = 'categoryArticle';
    private $params              = [];
    private $model;
    public function __construct()
    {
        parent::__construct();
        View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['locale']         = $this->getLocale();
        $this->params['category_id'] = $request->category_id;
        $articleModel           = new ArticleModel();
        $categoryArticleModel   = new CategoryArticleModel();
        $itemCategoryArticle    = $categoryArticleModel->getItem($this->params,['task'=>'news-get-item']);

        if(empty($itemCategoryArticle)) return redirect()->route('home'); // Nếu trường hợp view nhập category_id ko tồn tại thì trả về trang home ngay!

        $itemsLatest                    = $articleModel->listItems($this->params, ['task'=> 'news-list-items-latest']);
        $itemCategoryArticle['article'] = $articleModel->listItems($this->params, ['task'=> 'news-list-items-in-category']);

        //Lấy danh sách con
        $categoryChildList       = $categoryArticleModel->listItems($this->params,['task' => 'category-child']);
        //Lấy danh sách bài viết từ danh sách category con
        if($categoryChildList != null){
            $params             = [];
            $params['locale']   = $this->locale;
            foreach($categoryChildList as $valueCategoryChild ){
                $params['category_id'][] = $valueCategoryChild['id'];
            }

            $articlesInChild            = $articleModel->listItems($params, ['task'=> 'news-list-items-in-category-id-array']);
            //Gán
            $itemCategoryArticle['article_child'] = $articlesInChild;
        }
        $breadcrumbs = $categoryArticleModel->listItems($this->params,['task' => 'category-family-ancestors']);

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'itemsLatest'          => $itemsLatest,
             'itemCategoryArticle'  => $itemCategoryArticle,
             'breadcrumbs'          => $breadcrumbs
        ]);
    }

}

