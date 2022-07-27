<?php

namespace App\Services;

class LogoutService
{
    /**
     * Handle logout
     * 
     * @return void
     */
    public function logout()
    {
        $user = auth()->user();

        $user->tokens()->delete();
    }
}
