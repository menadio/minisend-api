<?php

namespace App\Http\Controllers;

use App\Services\LogoutService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LogoutService $logoutService)
    {
        $logoutService->logout();

        return $this->successRes('Successful operation', null);
    }
}
