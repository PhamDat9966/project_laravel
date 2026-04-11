<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\SettingModel as MainModel;
use App\Http\Requests\VideoRequest as MainRequest;

class VideoController extends AdminController
{
    public function __construct()
    {
        $this->model  = new MainModel();
        $this->pathViewController   = 'admin.pages.video.';
        $this->controllerName       = 'video';
        View::share('controllerName',$this->controllerName);
        parent::__construct();
    }

    public function index(Request $request) //index trèn thêm dữ liệu
    {
        $items    = [];
        $apiKey   = config('zvn.youtube_api_key');
        $setting  = DB::table('setting')
                        ->where('key_value', 'setting-video')
                        ->first();
        $playlistYoutube    = $setting->value;

        // Phân tích URL để lấy các tham số query
        parse_str(parse_url($playlistYoutube, PHP_URL_QUERY), $queryParams);

        // Lấy PLAYLIST_ID từ tham số 'list'
        $playlistId = $queryParams['list'] ?? null;

        $apiUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId={$playlistId}&maxResults=50&key={$apiKey}";

        // Gửi yêu cầu API
        $response = file_get_contents($apiUrl);

        // Chuyển đổi JSON thành mảng PHP
        $items = json_decode($response, true);

        return view($this->pathViewController .  'index', [
            'playlistYoutube'   => $playlistYoutube,
            'items'             => $items,
        ]);
    }

    public function save(MainRequest $request) // MainRequest là đối tượng $request có validate
    {
        $this->clearCache();
        if($request->method() == 'POST'){

            $params = $request->all();  // Lấy param từ request
            $task   = 'edit-list-play-youtube';
            $notify = 'Cập nhật list play video thành công!';
            $this->model->saveItem($params,['task'=>$task]);
            return redirect()->route($this->controllerName)->with('zvn_notily', $notify);
        }
    }

}

