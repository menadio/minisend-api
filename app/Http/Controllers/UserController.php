<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Email;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $user = auth()->user();

        return $this->successRes(
            'Retrieved user successfully',
            new UserResource($user)
        );
    }
}
