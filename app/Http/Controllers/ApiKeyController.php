<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Fetch api key
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        $token = auth()->user()->token;

        $data = ['api_key' => $token];

        return $this->successRes(
            'Retrieved key successfully',
            $data
        );
    }

    /**
     * Update api key
     * 
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $user = auth()->user();

        $token = $user->createToken();

        $user->update(['token' => $token]);

        return $this->successRes(
            'Api key update successful',
            null
        );
    }
}
