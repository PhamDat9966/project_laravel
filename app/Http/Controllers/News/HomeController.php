<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\SliderModel;
use App\Models\CategoryArticleModel;
use App\Models\ArticleModel;

use Illuminate\Session\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends LocaleController
{
    private $pathViewController  = 'news.pages.home.';
    private $controllerName      = 'home';
    private $params              = [];
    private $model;

    public function __construct()
    {
        parent::__construct();
        View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['locale'] = $this->getLocale();

        $sliderModel    = new SliderModel();
        $categoryModel  = new CategoryArticleModel();
        $articleModel   = new ArticleModel();

        $itemsSlider    = $sliderModel->listItems($this->params, ['task'=>'news-list-items']);
        $itemsCategory  = $categoryModel->listItems($this->params, ['task'=> 'news-list-items-is-home']);
        $itemsFeature   = $articleModel->listItems($this->params, ['task'=> 'news-list-items-feature']);

        // Trường hợp số bài viết nổi bật thấp hơn 3
        if(count($itemsFeature) < 3){
            $itemsFeatureAdd   = $articleModel->listItems($this->params, ['task'=> 'news-list-items-many-conditions']); // Lấy dữ liệu bao gồm cả nổi bật và không nổi bật
            shuffle($itemsFeatureAdd);
            $itemsFeature      = array_merge($itemsFeature,$itemsFeatureAdd);
            $itemsFeature = array_slice($itemsFeature, 0, 3);

        }

        $itemsLatest    = $articleModel->listItems($this->params, ['task'=> 'news-list-items-latest']);
        foreach($itemsCategory as $key=>$value){
            $this->params['category_id'] = $value['id'];
            $itemsCategory[$key]['article'] = $articleModel->listItems($this->params, ['task'=> 'news-list-items-in-category']);
        }

        $itemsUsually = '';
        if (Session::has('userInfo')) {
            $userInfo = Session::get('userInfo');
            $itemsUsually = $this->usuallyItem($userInfo); // Bài viết đề xuất theo session
        }

        $itemsCategoryPage = $itemsCategory;
        shuffle($itemsCategoryPage); //Xáo chộn các phần tử trước khi đưa ra home

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'itemsSlider'          => $itemsSlider,
             'itemsCategory'        => $itemsCategory,
             'itemsFeature'         => $itemsFeature,
             'itemsLatest'          => $itemsLatest,
             'itemsUsually'         => $itemsUsually,
             'itemsCategoryPage'    => $itemsCategoryPage
        ]);
    }

    public function usuallyItem($userInfo){

        $categoryModel  = new CategoryArticleModel();
        $articleModel   = new ArticleModel();

        $listCategoryID = array();
        $listCategoryID = $categoryModel->listItems(null,['task'=>'category-list-id']);
        $this->params['listCategoryID'] = $listCategoryID;
        // Trường hợp user chưa xem bài nào thì tạo một chuỗi ngẫu nhiên từ danh sách categoryID để làm  nhóm bài viết đề xuất
        if($userInfo['usually_category'] == null){
            $resultRamdomString = '';
            for ($i = 0; $i <= 10; $i++) {
                $randomIndex = array_rand($listCategoryID);
                $resultRamdomString .= $listCategoryID[$randomIndex]['id'] . ',';
            }
            $userInfo['usually_category'] = $resultRamdomString;
        }

        // Nhóm bài viết "thường đọc - đề xuất". Gồm Max là category được xem nhiều nhất và secondHighest là category được xem nhiều thứ 2
        // Max lấy 2 bài và secondHighest lấy 1 bài

        $usuallyCategoryAr          = explode(',',$userInfo['usually_category']);
        $usuallyCategoryCount       = array_count_values($usuallyCategoryAr);
        $maxValue                   = max($usuallyCategoryCount);
        $maxKey                     = array_search($maxValue, $usuallyCategoryCount);
        $this->params['usually_key_max']  = $maxKey;// Đây là key category được xem nhiều nhất
        //Lấy key value nhiều thứ 2
        // Sắp xếp mảng theo giá trị giảm dần
        arsort($usuallyCategoryCount);

        $secondHighest = 1;
        if(!isset(array_keys($usuallyCategoryCount)[1])){
            /*
                Trường hợp danh sách thường xem chưa có value nhiều thứ 2:
                Lấy ramdoom một phần tử bất kỳ từ danh sách category rồi đặt cho secondHighest để tránh lỗi
            */

            // Lấy một khóa ngẫu nhiên từ mảng
            $randomKey = array_rand($listCategoryID);
            // Lấy phần tử tương ứng với khóa ngẫu nhiên
            $randomElement = $listCategoryID[$randomKey];
            $secondHighest = $randomElement['id'];
        }else{
            $secondHighest = array_keys($usuallyCategoryCount)[1];
        }

        $this->params['usually_key_second_highest']  = $secondHighest;
        // Suy xuất đến model
        $itemsUsually           = $articleModel->listItems($this->params, ['task'=> 'news-list-items-usually-max']); // Chọn 6 phần tử mới nhất
        shuffle($itemsUsually);
        $itemsUsually           = array_slice($itemsUsually, 0, 2); //chỉ lấy 2 phần tử của mảng sau khi xáo chộn mảng
        $itemsUsually[]         = $articleModel->listItems($this->params, ['task'=> 'news-list-items-usually-second-highest']); // Kết hợp 1 phần tử của category được xem nhiều thứ 2

        return $itemsUsually;
    }

}

