<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Webpatser\Uuid\Uuid;

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

    protected function getStatusTitle(){
        return [
            ['title'=> 'De Active', 'class' => 'badge-light-warning'],
            ['title'=> 'Active', 'class' => 'badge-light-success']
        ];
    }
    protected function strUCWord($str){
        return ucwords(strtolower(strtoupper(trim($str))));
    }
    protected function uuid(){
        return Uuid::generate()->string;
    }

    public static function insertAddress($request,$modal){
        $address = new Address();
        $address->country_id = $request->country_id;
        $address->region_id = $request->region_id;
        $address->city_id = $request->city_id;
        $address->address = $request->address;

        if(empty($modal->addresses)){
            $modal->addresses()->save($address);
        }else{
            $modal->addresses()->update($address->toArray());
        }
    }
}
