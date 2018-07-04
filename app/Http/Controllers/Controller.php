<?php

namespace App\Http\Controllers;

use App\Repositories\ApiRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendRes($msg = '', $result = null)
    {
        $response = [
            'success' => true,
            'message' => $msg,
        ];
        if ($result) $response['data'] = $result;

        return response()->json($response, 200);
    }

    public function sendErr($msg = [], $error, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (count($msg)) $response['data'] = $msg;

        return response()->json($response, $code);
    }
}
