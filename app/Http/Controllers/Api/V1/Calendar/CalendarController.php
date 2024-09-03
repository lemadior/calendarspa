<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Calendar\CalendarResource;
use Illuminate\Http\Request;


class CalendarController extends Controller
{
    public function index(Request $request)
    {
        return new CalendarResource($request);
    }
}
