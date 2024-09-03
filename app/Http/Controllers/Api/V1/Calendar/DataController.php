<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Calendar\TypeDataResource;
use App\Http\Resources\Api\V1\Calendar\StatusDataResource;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getTypes(Request $request)
    {
        return new TypeDataResource($request);
    }

    public function getStatuses(Request $request)
    {
        return new StatusDataResource($request);
    }
}
