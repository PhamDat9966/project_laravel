<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\RssModel as MainModel;
use App\Http\Requests\RssRequest as MainRequest;
use App\Models\RssModel;
use App\Helpers\Feed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class RsscontainerController extends Controller
{
    private $pathViewController  = 'admin.pages.rsscontainer.';
    private $controllerName      = 'rsscontainer';
    private $params              = [];
    private $model;

    public function __construct()
    {
      $this->model  = new MainModel();
      $this->params['pagination']['totalItemsPerPage']  = 10;
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        $allParams = $request->all();

        $this->params['filter']['status']   = $request->input('filter_status','all');
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        $rssModel    = new RssModel();
        $itemsRss    = $rssModel->listItems(null, ['task'=>'news-list-items']);

        $data       = Feed::read($itemsRss);
        //Lọc dữ liệu theo thời gian hiện tại
        $dataNew    = array();

        // Lấy thời gian hiện tại
        $now = Carbon::now();
        $nowDay = $now->toDateString();

        foreach($data as $value){
            // Chuyển đổi thời gian về dạng Y-m-d
            $pubDate = Carbon::parse($value['pubDate']);
            $pubDate = $pubDate->toDateString();
            //Lọc lại chỉ lấy những tin trùng với current day
            if($nowDay == $pubDate){
                $dataNew[] = $value;
            }
        }

        $currentdate = date('Y-m-d');
        $pubDateFirst = $data[0]['pubDate'];
        // Chuyển đổi chuỗi thành đối tượng Carbon
        $date = Carbon::parse($pubDateFirst);
        // Lấy ngày dưới dạng "Y-m-d"
        $strDate = $date->format('Y-m-d');


        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $data,
        ]);
    }

    public function form(Request $request)
    {
        $item   = null;
        if($request->id !== null){
            $params['id']   = $request->id;
            $item = $this->model->getItem($params,['task'=>'get-item']);
        }

        return view($this->pathViewController . 'form', [
            'item'=>$item
        ]);
    }

    public function status(Request $request)
    {
         Cache::flush();
        $params['currentStatus']    = $request->status;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-status']);
        // End Update

        $statusAction       = "đã được kích hoạt";
        $statusNextAction   = "chưa kích hoạt";
        if($params['currentStatus'] == 'inactive'){
            $statusAction = 'chưa kích hoạt';
            $statusNextAction   = "đã được kích hoạt";
        }
        return redirect()->route($this->controllerName)->with('zvn_notily','Trạng thái ID = '.$params['id'].' với trạng thái "'.$statusAction.'" đã được thay đổi thành trạng thái "'.$statusNextAction.'" !');
    }
    public function delete(Request $request)
    {
         Cache::flush();
        $params['id']               = $request->id;
        $this->model->deleteItem($params,['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử ID = ' .$params['id'] .' đã được xóa!');
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
         Cache::flush();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request
            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';

            if($params['id'] !== null){
                $task = 'edit-item';
                $notify   = 'Cập nhật thành công!';
            }
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

    public function ordering(Request $request){
         Cache::flush();
        $params['id']       = $request->id;
        $params['ordering']    = $request->ordering;

        $this->model->saveItem($params,['task' => 'change-ordering']);
        echo "Cập nhật menu thành công";
    }


}

