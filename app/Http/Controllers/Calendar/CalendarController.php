<?php

namespace App\Http\Controllers\Calendar;


use App\Http\Requests\Calendar\CalendarRequest;
use App\Http\Requests\Calendar\DayRequest;
use App\Services\Calendar\EventService;
use App\Services\Calendar\DateService;
use App\Http\Controllers\Controller;
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

    /**
     * Get data for the Month based on specified date
     *
     * @param \App\Http\Requests\Calendar\CalendarRequest $request
     *
     * @return \Inertia\Response
     */
    public function index(CalendarRequest $request)
    {
        $data = $request->validated();

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

    /**
     * Events Summary of the Day
     *
     * @param \App\Http\Requests\Calendar\DayRequest $request
     *
     * @return \Inertia\Response
     */
    public function showDay(DayRequest $request)
    {
        $data = $request->validated();

        $data['day'] = $this->dateService->getFullNameOfDay($data['date']);

        $data['events'] = $this->eventService->getEventsByDate($data['date']);

        return Inertia::render("Calendar/Day", ['data' => $data]);
    }
}
