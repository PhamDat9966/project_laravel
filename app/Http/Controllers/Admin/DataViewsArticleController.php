<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\DataViewsArticleModel as MainModel;

use App\Models\UserAgentsModel;
use App\Models\ArticleModel;

class DataViewsArticleController extends Controller
{
    private $pathViewController  = 'admin.pages.dataViewsArticle.';
    private $controllerName      = 'dataViewsArticle';
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

        $this->params['filter']['status']   = $request->input('filter_status','all');
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        $this->params['filter']['category']   = $request->input('filter_category','all');
        $this->params['filter']['type']       = $request->input('filter_type','all');

        //Cập nhật Lượt Views theo 'user_agents' table
        $userAgentModel = new UserAgentsModel();
        $dataUserAgent  = $userAgentModel->listItems($params = null,['task'=>'user_agents-list-items']);
        // Mảng $newDataView sẽ xóa các phần tử trùng 'agent' và 'article_id' trong $dataUserAgent
        $newDataView = [];

        // Loại bỏ những views trùng nhau của user theo UserAgent
        foreach ($dataUserAgent as $item) {
            $isDuplicate = false;

            // Kiểm tra xem có phần tử nào trong mảng mới có 'agent' và 'article_id' giống không
            foreach ($newDataView as $newItem) {

                if ($item['agent'] === $newItem['agent']  && $item['article_id'] === $newItem['article_id']) {
                    $isDuplicate = true;
                    break;
                }
            }

            // Nếu không trùng, thêm vào mảng mới
            if (!$isDuplicate) {
                $newDataView[] = $item;
            }
        }

        // Mảng đếm số lần xuất hiện của articleId
        $articleCounts = array();

        foreach ($newDataView as $item) {
             $articleId = $item['article_id'];

            // Nếu $articleId chưa tồn tại trong mảng $articleCounts, thêm mới
            if (!isset($articleCounts[$articleId])) {
                $articleCounts[$articleId] = 1;
            } else {
                // Ngược lại, tăng giá trị đếm lên 1
                $articleCounts[$articleId]++;
            }
        }

        // Sử dụng array_filter để loại bỏ key rỗng
        $articleCounts = array_filter($articleCounts, function($value, $key) {
            return $key !== "";
        }, ARRAY_FILTER_USE_BOTH);

        // Cập nhật dataViews theo articleCount
        $dataViewsArticleModel  = new MainModel();
        $listItemsDataView      = $dataViewsArticleModel->getItem(null,['task'=>'get-all-item']);

        //updateView nếu trường hợp chưa có phần tử
        foreach($articleCounts as $key=>$value){
            //Nếu phần tử trong $articleCounts không tồn tại trong dataViewArticel thì thêm mới nó vào csdl
            if (!in_array($key, array_column($listItemsDataView, 'article_id'))) {
                $params['article_id'] = $key;
                $params['views']      = $value;
                $params['status']     = 'active';
                $dataViewsArticleModel->saveItem($params,['task'=>'add-item']);
            }else{
                //Nếu có phần tử trong $articleCounts thì Cập nhật lại số views
                $params['article_id'] = $key;
                $params['views']      = $value;
                $params['status']     = 'active';
                $dataViewsArticleModel->saveItem($params,['task'=>'update-views']);
            }
        }

        $items              = $this->model->listItems($this->params,['task' => "data-view-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $items,
             'itemsStatusCount'     => $itemsStatusCount,
        ]);
    }

}

// php artisan make:model ArticalModel
