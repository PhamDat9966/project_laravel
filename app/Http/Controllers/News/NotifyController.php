<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Models\ArticleModel;

class NotifyController extends Controller
{
    private $pathViewController  = 'news.pages.notify.';
    private $controllerName      = 'notify';
    private $params              = [];
    private $model;

    public function __construct()
    {
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function noPermission(Request $request)// Ở Laravel, request sẽ lấy parameter từ url, ở đây tiêu biểu là lấy $_GET và $_POST
    {

        $this->params['article_id']     = $request->article_id;
        $this->params['article_name']   = $request->article_name;
        $this->params['locale']         = $request->locale;

        $articleModel   = new ArticleModel();
        $itemsLatest    = $articleModel->listItems($this->params, ['task'=> 'news-list-items-latest']);

        return view($this->pathViewController . 'no-permission',[
             'params'       => $this->params,
             'itemsLatest'  => $itemsLatest,
             'locale'       => $this->params['locale']
        ]);
    }

}

