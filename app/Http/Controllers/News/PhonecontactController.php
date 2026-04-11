<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

use App\Models\PhonecontactModel;

class PhonecontactController extends LocaleController
{
    private $pathViewController  = 'news.pages.phonecontact.';
    private $controllerName      = 'phonecontact';
    private $params              = [];
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new PhonecontactModel();
        View::share('controllerName',$this->controllerName);
    }

    public function contact(Request $request)// Ở Laravel, request sẽ lấy parameter từ url, ở đây tiêu biểu là lấy $_GET và $_POST
    {
        $locale    = App::getLocale();
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $message = 'Nếu bạn không phải là Robot. Vui lòng xác nhận reCAPTCHA';
        if($locale == 'en'){
            $message = 'If you are not a Robot. Please confirm reCAPTCHA';
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $message
            ], 422);
        }
        $phone                  = $request->input('phone');
        $param                  = [];
        $param['phonecontact']  = $phone;
        $this->model->saveItem($param,['task' => 'add-item']);

        $returnMessage = ($locale == 'en') ? 'Data added successfully' : 'Đã thêm dữ liệu thành công';

        return $returnMessage;
    }

    public function saveUsuallyCategory(){

    }

}
