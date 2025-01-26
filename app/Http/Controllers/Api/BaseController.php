<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    static function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'err_res' => '',
            'status' => 200,
            'data'    => $result,
        ];


        return response()->json($response, 200);
    }

    static function sendResponseMobileApp($message=null, $totalCount=null, $data=null)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'status' => 200,
            'totalCount' => $totalCount,
            'data' => $data,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    static function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    static function sendErrorApps($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'status' => false,
            'message' => $error,
            'code'  =>$code,
        ];


        return response()->json($response);
    }
}