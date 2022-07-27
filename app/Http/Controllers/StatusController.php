<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $statuses = Status::all();

        return $this->successRes(
            'Retrieved statuses successfully',
            StatusResource::collection($statuses)
        );
    }
}
