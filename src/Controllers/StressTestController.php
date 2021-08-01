<?php

namespace StressTest\Controllers;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
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

    public function closeDbConnection()
    {
        return $this->issueResponse(function() {
            return DB::disconnect();
        });
    }

    public function eloquentFetchAll(Request $request)
    {
        return $this->issueResponse(function() use ($request) {
            $model = $request->post('entity');
            $namespace = 'App\Models\\' . $model;
            if (!class_exists($namespace))
                return response()->json(['error' => 'Model ' . $namespace . ' not found.'], 404);
            DB::enableQueryLog();
            $namespace::all();
            DB::getQueryLog();

            return response()->json(['log' => DB::getQueryLog()]);
        });
    }

    private function issueResponse(callable $callback)
    {
        try {
            return response()->json($callback());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'cwd' => getcwd()], 500);
        }
    }
}