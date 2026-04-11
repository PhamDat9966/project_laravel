<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class DailySchedulerController extends Controller
{
    public function runDailyTask()
    {
        // Dùng BufferedOutput để lấy kết quả từ command
        $output = new BufferedOutput();

        try {
            Artisan::call('daily:task', [], $output);
            $result = $output->fetch();

            return response()->json([
                'success' => true,
                'message' => trim($result)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Command execution failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
