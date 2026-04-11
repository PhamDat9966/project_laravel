<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\RssnewsModel;
use App\Helpers\Feed;
use App\Helpers\Pagination;

use Illuminate\Support\Facades\Session;
use Illuminate\Session\Store;

use Illuminate\Support\Facades\App;
class RssController extends LocaleController
{
    private $pathViewController  = 'news.pages.rss.';
    private $controllerName      = 'rss';
    private $params              = [];
    private $model;
    // public $_pagination = array(
    //                               'totalItemsPerPage' => 6,
    //                               'pageRange'         => 3,
    //                               'currentPage'       => 1,
    //                             );
    protected $locale;
    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage']  = 10;
        parent::__construct();
        View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['locale']             = $this->getLocale();
        $this->params['page']               = $request->input('page');
        $this->params['search']['value']    = $request->input('search_value_rss');
        $this->params['search']['field']    = 'title';

        $title  = ($this->locale == 'en') ? 'General news' : 'Tin tức tổng hợp';
        //dd($this->params['search']);
        View::share('title',$title);
        $rssnewsModel   = new RssnewsModel();
        $itemsRssnews   = $rssnewsModel->listItems($this->params, ['task'=>'admin-list-items']);

        $itemsCoin  = Feed::getCoin();

        return view($this->pathViewController . 'index',[
            'locale'    =>$this->locale,
            'params'    =>$this->params,
            'items'     =>$itemsRssnews,
            'itemsCoin' =>$itemsCoin
       ]);
    }

    public function getGold(){

        $itemsGold  = Feed::getGold();
        // Cách viết để dễ hiều: Lấy toàn bộ nội dung của html `box-gold` tại `view` có gáng mảng itemsGold
        $viewContentGold = View::make($this->pathViewController . 'child-index.box-gold',['itemsGold' =>$itemsGold])->with('itemsGold', $itemsGold)->render();
        return $viewContentGold;

    //     return view($this->pathViewController . 'child-index.box-gold',[
    //         'itemsGold' =>$itemsGold
    //    ]);

    }

    public function getCoin(){
        $itemsCoin  = Feed::getCoin();
        $viewContentCoin = View::make($this->pathViewController . 'child-index.box-coin',['itemsCoin' =>$itemsCoin])->with('itemsCoin', $itemsCoin)->render();
        return $viewContentCoin;

    //     return view($this->pathViewController . 'child-index.box-coin',[
    //         'itemsCoin' =>$itemsCoin
    //    ]);

    }

}

