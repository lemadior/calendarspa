<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\DayRequest;
use App\Services\Calendar\EventService;
use App\Services\Calendar\DateService;
use App\Http\Requests\Calendar\CalendarRequest;
// use Illuminate\Http\Request;
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

    public function index(CalendarRequest $request)
    {
        $data = $request->validated();

        // $data['date'] = $request->query('date');

        if ($data && !empty($data['date']) && strpos($data['date'], 'T')) {
            $data['date'] = $this->dateService->scrubDate($data['date']);
        }

        $incomingDate = $data['date'] ?? date('Y-m-d');

        $monthData = [];

        for ($i = 1; $i <= 6; $i++) {
            $monthData[] = $this->eventService->getDaysWithEventsByWeek($incomingDate, $i);
        }

        return Inertia::render('Calendar/Calendar', [
            'monthData' => $monthData,
            'incomingDate' => $incomingDate
        ]);
    }

    public function showDay(DayRequest $request)
    {
        $data = $request->validated();

        $data['day'] = $this->dateService->getFullNameOfDay($data['date']);

        $data['events'] = $this->eventService->getEventsByDate($data['date']);

        return Inertia::render("Calendar/Day", ['data' => $data]);
    }
}
