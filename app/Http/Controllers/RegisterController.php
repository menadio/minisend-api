<?php

namespace App\Http\Controllers;

use App\Services\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, RegisterService $registerService)
    {
        $token = $registerService->register($request);

        $data = ['accessToken' => $token];

        return $this->successRes(
            'Registration succesful',
            $data
        );
    }
}
