<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoginService;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, LoginService $loginService)
    {
        $user = $loginService->checkCredentials($request);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorRes('Email/Password mismatch', null, 400);
        }

        $token = $user->createToken(env('APP_TOKEN_NAME'));

        $data = ['accessToken' => $token->plainTextToken];

        return $this->successRes(
            'Login succesful',
            $data
        );
    }
}
