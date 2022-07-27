<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterService
{
    /**
     * Handles new user registration
     * 
     * @param \Illuminate\Http\Request $request
     * @return Laravel\\Sanctum\\NewAccessToken
     */
    public function register(Request $request)
    {
        // validate request
        $this->validate($request);

        // create new user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $this->generateApiKey($user);

        // generate token
        $token = $user->createToken(env('APP_TOKEN_NAME'));

        return $token->plainTextToken;
    }

    /**
     * Generate API key for new user
     * 
     * @param \App\Models\User $user
     * @return void
     */
    public function generateApiKey($user): void
    {
        // generate api key
        $apiKey = $user->createToken(env('APP_TOKEN_NAME'))->accessToken;

        $user->update(['token' => $apiKey->token]);
    }

    /**
     * validate request
     * 
     * @param \Illuminate\Http\Request $request
     * @return any
     */
    public function validate($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:App\Models\User,email', 'email:rfc,dns'],
            'password' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->first()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
