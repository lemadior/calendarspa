<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\DayRequest;
use App\Services\Calendar\EventService;
use App\Services\Calendar\DateService;
use App\Http\Requests\Calendar\CalendarRequest;
use App\Models\Calendar\Event;
use DateTime;
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

        $data['date'] = $request->query('date');

        // if ($data['date']) {
        //     dd($data['date']);
        // }

        if ($data && !empty($data['date']) && strpos($data['date'], 'T')) {
            $data['date'] = $this->dateService->scrubDate($data['date']);
        }

        $incomingDate = $data['date'] ?? date('Y-m-d');
        // $incomingDate = $data['date'] ?? date('2024-07-23');
        // dd($incomingDate);
        $monthData = [];

        for ($i = 1; $i <= 6; $i++) {
            $monthData[] = $this->eventService->getDaysWithEventsByWeek($incomingDate, $i);
        }

        // if ($data) {
        //     dd($monthData);
        // }

        return Inertia::render('Calendar/Calendar', [
            'monthData' => $monthData,
            'incomingDate' => $incomingDate
        ]);
    }

    public function showDay(DayRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        // $date = $this->dateService->getDate($data['date']);
        $data['day'] = $this->dateService->getFullNameOfDay($data['date']);
        // $data['events'] = !empty($data['events']) ? Event::whereIn('id', $data['events'])->get() : [];
        // $data['events'] = Event::whereDate('date', $data['date'])->get();
        $data['events'] = $this->eventService->getEventsByDate($data['date']);
        // dd($data);

        return Inertia::render("Calendar/Day", ['data' => $data]);
    }
}
