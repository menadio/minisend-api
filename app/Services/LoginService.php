<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginService extends Controller
{
    /**
     * Handle login attempt
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function checkCredentials(Request $request)
    {
        // validate request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // retrieve user if exist
        $user = User::where('email', $request->email)->first();

        return $user;
    }
}
