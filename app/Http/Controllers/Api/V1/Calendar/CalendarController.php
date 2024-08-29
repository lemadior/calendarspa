<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Services\Calendar\EventService;
use App\Services\Calendar\DateService;
use App\Http\Requests\Calendar\CalendarRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    // protected const DAYS_IN_WEEK = 7;

    protected EventService $eventService;
    protected DateService $dateService;

    public function __construct()
    {
        $this->eventService = app(EventService::class);
        $this->dateService = app(DateService::class);
    }

    public function index(Request $request)
    {
        // if ($request->query('date')) {
        //     dd($request->query('date'));
        // }

        // $data = $request->validated();
        // dump($request);
        $data['date'] = $request->query('date');

        // if ($data['date']) {
        //     dd($data['date']);
        // }

        if ($data && !empty($data['date']) && strpos($data['date'], 'T')) {
            $data['date'] = $this->dateService->scrubDate($data['date']);
        }

        $incomingDate = $data['date'] ?? date('Y-m-d');

        // return response()->json($incomingDate);

        $monthData = [];

        for ($i = 1; $i <= 6; $i++) {
            $monthData[] = $this->eventService->getDaysWithEventsByWeek($incomingDate, $i);
        }

        // if ($data) {
        //     dd($monthData);
        // }

        return response()->json($monthData);
    }
}
