<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\RssModel as MainModel;
use App\Http\Requests\RssRequest as MainRequest;

use Config;
use Illuminate\Support\Facades\Cache;
class RssController extends Controller
{
    private $pathViewController  = 'admin.pages.rss.';
    private $controllerName      = 'rss';
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

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $items,
             'itemsStatusCount'     => $itemsStatusCount
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

    // public function status(Request $request)
    // {

    //     $params['currentStatus']    = $request->status;
    //     $params['id']               = $request->id;

    //     $this->model->saveItem($params,['task' => 'change-status']);
    //     // End Update

    //     $statusAction       = "đã được kích hoạt";
    //     $statusNextAction   = "chưa kích hoạt";
    //     if($params['currentStatus'] == 'inactive'){
    //         $statusAction = 'chưa kích hoạt';
    //         $statusNextAction   = "đã được kích hoạt";
    //     }
    //     return redirect()->route($this->controllerName)->with('zvn_notily','Trạng thái ID = '.$params['id'].' với trạng thái "'.$statusAction.'" đã được thay đổi thành trạng thái "'.$statusNextAction.'" !');
    // }

    public function status(Request $request)
    {
        Cache::flush();
        $params['currentStatus']    = $request->status;
        $params['id']               = $request->id;
        $status = $request->status == 'active' ? 'inactive' : 'active';

        $returnModified                 = $this->model->saveItem($params,['task' => 'change-status']);

        $userIcon   = config('zvn.template.font_awesome.user');
        $clockIcon  = config('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];

        //Class của bootstrap và class khi status thay đổi trạng thái sẽ được quyết định tại đây
        $infomationStatus           =   Config::get('zvn.template.status')[$status];
        $infomationStatus['class']  =   'btn btn-round status-ajax '. $infomationStatus['class'];

        $link = route($this->controllerName . '/status',['status'=>$status, 'id'=>$request->id]);

        return response()->json([
            'status'        =>  $infomationStatus,
            'link'          =>  $link,
            'modified'      =>  $returnModified['modified'],
            'modified_by'   =>  $returnModified['modified_by'],
        ]);

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

        $returnModified = $this->model->saveItem($params,['task' => 'change-ordering']);

        $userIcon   = Config::get('zvn.template.font_awesome.user');
        $clockIcon  = Config::get('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];

        //trả về là chuỗi json mà Ajax không cần chuyển đổi
        return response()->json([
            'modified'      =>$returnModified['modified'],
            'modified_by'   =>$returnModified['modified_by'],
        ]);
    }
}

