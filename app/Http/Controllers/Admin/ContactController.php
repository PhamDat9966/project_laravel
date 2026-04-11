<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactModel as MainModel;
use App\Http\Requests\ContactRequest as MainRequest;
use Config;

class ContactController extends Controller
{
    private $pathViewController = 'admin.pages.contact.';  // slider
    private $controllerName     = 'contact';
    private $params             = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {

        $this->params['filter']['status']   = $request->input('filter_status', 'all');
        $this->params['filter']['timeMeet'] = $request->input('filter_timeMeet');
        $this->params['search']['field']    = $request->input('search_field', ''); // all id description
        $this->params['search']['value']    = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task'  => 'admin-list-items']);
        $itemsStatusCount   = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']); // [ ['status', 'count']]

        return view($this->pathViewController .  'index', [
            'params'        => $this->params,
            'items'         => $items,
            'itemsStatusCount' =>  $itemsStatusCount
        ]);
    }

    public function save(MainRequest $request)
    {
        $this->clearCache();
        if ($request->method() == 'POST') {
            $params = $request->all();

            $task   = "add-item";
            $notify = "Thêm phần tử thành công!";

            if ($params['id'] !== null) {
                $task   = "edit-item";
                $notify = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);
            return redirect()->route($this->controllerName)->with("zvn_notify", $notify);
        }
    }

    public function status(Request $request)
    {
        $this->clearCache();
        $params["currentStatus"]  = $request->status;
        $params["id"]             = $request->id;
        $this->model->saveItem($params, ['task' => 'change-status']);
        $status         = $request->status == 'active' ? 'inactive' : 'active';
        $link           = route($this->controllerName . '/status', ['status' => $status, 'id' => $request->id]);

        //Class của bootstrap và class khi status thay đổi trạng thái sẽ được quyết định tại đây
        $infomationStatus           =   Config::get('zvn.template.statusAppointment')[$status];
        $infomationStatus['class']  =   'btn btn-round status-ajax '. $infomationStatus['class'];

        return response()->json([
            'status'    => $infomationStatus,
            'link'      => $link,
        ]);
    }

    public function delete(Request $request)
    {
        $this->clearCache();
        $params["id"]             = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notify', 'Xóa phần tử thành công!');
    }
}
