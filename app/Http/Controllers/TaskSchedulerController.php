<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TaskSchedulerController extends Controller
{
    public function runDailyTask()
    {
        // Lấy thời gian hiện tại
        $now = Carbon::now();
        // Lấy thời gian chạy cuối cùng từ cache
        $lastRun = Cache::get('last_run_daily_task');

        // Kiểm tra nếu không có thời gian chạy cuối cùng hoặc đã quá 24 giờ kể từ lần chạy cuối cùng
        //if (!$lastRun || $now->diffInHours($lastRun) >= 24) {
        if (!$lastRun || $now->diffInMinutes($lastRun) >= 1) {
            // Chạy tác vụ hàng ngày
            Artisan::call('daily:task');
            // Cập nhật thời gian chạy cuối cùng vào cache
            Cache::put('last_run_daily_task', $now);

            // Lấy thông báo từ cache và trả về response.
            $message        = Cache::get('daily_task_message', 'Daily task has already run recently.');
            return response()->json(['message' => $message]);

            //$dataNewCache   = Cache::get('pubDate');
            //return response()->json(['dataNew' => $dataNewCache]);

        }

        return response()->json(['message' => 'Daily task has already been run recently.'], 200);
    }
}
