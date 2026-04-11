<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File; // Import thư viện File
use Illuminate\Support\Facades\App;
use Locale;

class GalleryshowController extends LocaleController
{
    private $pathViewController  = 'news.pages.gallery.';
    private $controllerName      = 'gallery';
    private $params              = [];
    private $model;

    public function __construct()
    {
        parent::__construct();
        View::share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['locale']         = $this->getLocale();
        $title = ($this->locale == 'en') ? 'Image Library':'Thư viện hình ảnh';
        view()->share('title', $title);
        $directory  = public_path(config('zvn.path.gallery'));
        //$directory  = public_path('images/shares'); // Đảm bảo đường dẫn thư mục đúng

        $images     = File::files($directory);
        return view($this->pathViewController . 'index', compact('images'));
    }
}
