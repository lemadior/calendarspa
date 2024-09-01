<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Services\Calendar\EventService;
use App\Services\Calendar\DateService;
use App\Http\Requests\Calendar\CalendarRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    protected EventService $eventService;
    protected DateService $dateService;

    public function __construct()
    {
        $this->eventService = app(EventService::class);
        $this->dateService = app(DateService::class);
    }

    public function index(Request $request)
    {
        $data['date'] = $request->query('date');

        if ($data && !empty($data['date']) && strpos($data['date'], 'T')) {
            $data['date'] = $this->dateService->scrubDate($data['date']);
        }

        $incomingDate = $data['date'] ?? Carbon::now('Europe/Kyiv')->format('Y-m-d');;

        $monthData = [];

        for ($i = 1; $i <= 6; $i++) {
            $monthData[] = $this->eventService->getDaysWithEventsByWeek($incomingDate, $i);
        }

        return response()->json(['monthData' => $monthData, 'incomingDate' => $incomingDate]);
    }
}
