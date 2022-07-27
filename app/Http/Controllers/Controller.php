<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success response
     * 
     * @return \Illuminate\Http\Response
     */
    public function successRes(String $message, $data)
    {
        if (is_null($data)) {
            return response()->json([
                'success' => true,
                'message' => $message
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], Response::HTTP_OK);
        }
    }

    /**
     * Error response
     * 
     * @return \Illuminate\Http\Response
     */
    public function errorRes(String $message, ?array $error, $code)
    {
        if (is_null($error)) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'success' => false,
                'message' => $message,
                'error' => $error
            ], $code);
        }
    }

    /**
     * Server error response
     * 
     * @return \Illuminate\Http\Response
     */
    public function serverError()
    {
        return response()->json([
            'success' => false,
            'message' => 'Server error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
