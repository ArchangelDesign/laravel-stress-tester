<?php

namespace StressTest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class StressTestController
 * @package StressTest\Controllers
 */
class StressTestController extends Controller
{
    public function alive()
    {
        return response()->json(
            [
                'appName' => env('APP_NAME'),
                'appEnv' => env('APP_ENV'),
                'appUrl' => env('APP_URL')
            ]
        );
    }

    public function isDbConnected()
    {
        return $this->issueResponse(function () {
            return response()->json(DB::statement('select 1 as "TRUE"'));
        });
    }

    public function getOpenDbConnections()
    {
        return $this->issueResponse(function () {
            return DB::selectOne('show status where variable_name = \'threads_connected\';');
        });
    }

    private function issueResponse(callable $callback)
    {
        try {
            return response()->json($callback());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}