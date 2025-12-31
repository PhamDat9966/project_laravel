<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Str;                 // Hỗ trợ thao tác chuỗi
use DB;                                     // DB thao tác trên csdl
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;     // Dùng để delete image theo location

class DashboardModel extends AdminModel
{
    public function __construct(){
        $this->table                = 'totalelements';
        $this->folderUpload         = 'totalelements';
    }

    public function listItems($params = null,$options = null){

        $result = null;
        if($options['task'] == 'admin-list-items'){
            $result = $this->select('TableName','ElementCount','icon')->get()->toArray();
        }
        return $result;
    }

    public function countItems($params = null,$options = null){

        $result = null;

        if($options['task'] == 'admin-count-category-item'){
            $this->table     = 'category_article';
            $query  = $this->select(DB::raw('COUNT(id) as count'));
            $result     = $query->get()
                                ->toArray();
        }

        if($options['task'] == 'admin-count-article-item'){
            $this->table     = 'article';
            $query  = $this->select(DB::raw('COUNT(id) as count'));
            $result     = $query->get()
                                ->toArray();
        }

        if($options['task'] == 'admin-count-slider-item'){
            $this->table     = 'slider';
            $query  = $this->select(DB::raw('COUNT(id) as count'));
            $result     = $query->get()
                                ->toArray();
        }

        if($options['task'] == 'admin-count-user-item'){
            $this->table     = 'user';
            $query  = $this->select(DB::raw('COUNT(id) as count'));
            $result     = $query->get()
                                ->toArray();
        }

        return $result;
    }

    public function update($params = null,$options = null){

        $result = null;
        $this->table = 'totalelements';
        if($options['task'] == 'admin-update-category-item'){
            $this::where('TableName', $params['category'])
                        ->update(['ElementCount' => $params['countCurrent']]);
        }

        if($options['task'] == 'admin-update-article-item'){
            $this::where('TableName', $params['article'])
                        ->update(['ElementCount' => $params['countCurrent']]);
        }

        if($options['task'] == 'admin-update-slider-item'){
            $this::where('TableName', $params['slider'])
                        ->update(['ElementCount' => $params['countCurrent']]);
        }

        if($options['task'] == 'admin-update-user-item'){
            $this::where('TableName', $params['user'])
                        ->update(['ElementCount' => $params['countCurrent']]);
        }

        return $result;
    }
}
