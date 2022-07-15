<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonSuccessResponse( $data, $message, $statusCode = 200 )
    {
        return response()->json(['status'=>'success', 'data'=>(object)$data, 'message'=>$message], $statusCode);
    }

    protected function jsonErrorResponse( $data, $message,  $statusCode = 203)
    {
        return response()->json(['status'=>'error', 'data'=>(object)$data, 'message'=>$message], $statusCode);
    }

    protected function arrSuccessResponse($data, $message)
    {
        return ['status'=>'success', 'data'=>$data, 'message'=>$message];
    }

    protected function arrErrorResponse($data, $message)
    {
        return ['status'=>'error', 'data'=>$data, 'message'=>$message];
    }

}
