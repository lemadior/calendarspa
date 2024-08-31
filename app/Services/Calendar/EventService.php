<?php

namespace App\Services\Calendar;

use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Services\Calendar\DateService;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;

class EventService
{
    // Authenticated user
    protected Authenticatable|User|null $user;

    protected DateService $dateService;

    public function __construct()
    {
        $this->user = auth()->user() ?? User::find(1); // TODO remove false condition after adding JWT token
        $this->dateService = app(DateService::class);
    }

    // function getDate(string $date): DateTime
    // {
    //     // If date coming in 'YYYY-mm-dd' format. Without time.
    //     if (strlen($date) <= 10) {
    //         $date .= ' 00:00:00';
    //     }

    //     return (new DateTime())::createFromFormat('Y-m-d H:i:s', $date);
    // }


    // // Get first day of the month relative based on incoming date
    // public function getFirstDayOfTheMonth(DateTime $date): DateTime
    // {
    //     $year = $date->format('Y');
    //     $month = $date->format('m');

    //     $firstDayDate = $year . '-' . $month . '-01 00:00:00';

    //     return $this->getDate($firstDayDate);
    // }


    // /*
    // * Generally the calendar will display six weeks. The first one always contain the first day in the month.
    // * But first week can starts from date of previous month.
    // * Get the first date for the first displayed week
    // */
    // public function getFirstDayOfFirstWeek(DateTime $baseDate): DateTime
    // {
    //     $initialDay = $this->getFirstDayOfTheMonth($baseDate);

    //     $initialDayPosition = $initialDay->format('w');

    //     return $initialDay->modify('-' . $initialDayPosition . ' day');
    // }

    // Get only events belongs to specified date ($weekdays)
    public function getEventsForWeekDay($events, DateTime $weekday): array
    {
        $weekEvents = [];

        $weekDay = $weekday->format('j');

        foreach ($events as $event) {
            $eventDate = $this->dateService->getDate($event->date);

            if ($eventDate->format('j') == $weekDay) {
                $weekEvents[] = $event;
            }
        }

        return $weekEvents;
    }

    // Get all events only for month depends on the baseDate for authenticated user
    protected function getEvents(DateTime $baseDate): Collection
    {
        // If user doesn't authenticated just return empty Collection
        // TODO add JWT token to the API part
        // if (!$this->user) {
        //     return new Collection();
        // }

        $baseYear = $baseDate->format('Y');
        $baseMonth = $baseDate->format('m');

        $events = User::find($this->user->id)?->events()
            ->whereYear('date', $baseYear)
            ->whereMonth('date', $baseMonth);

        // dump($events->select('title', 'start', 'duration', 'type_id', 'status_id', 'description', 'date')->get());

        return $events->select('title', 'start', 'duration', 'type_id', 'status_id', 'description', 'date')->get();
    }

    // $weekNumber allowed from 1 to 6!
    public function getDaysWithEventsByWeek(string $weekDate, int $weekNumber): array
    {
        if ($weekNumber < 1 || $weekNumber > 6) {
            throw new Exception('Incorrect number of week!');
        }

        $today = $this->dateService->getDate(date('Y-m-d'));

        $week = [];

        $baseDate = $this->dateService->getDate($weekDate);

        $baseMonth = $baseDate->format('m');
        // dump($baseMonth);
        // Get events depends on month from $baseDate
        $events = $this->getEvents($baseDate);

        $startDay = $this->dateService->getFirstDayOfFirstWeek($baseDate);

        $startWeek = $weekNumber - 1;

        $startDay->modify('+' . $startWeek . ' week');
        // dd($startDay);
        for ($i = 0; $i <= 6; $i++) {

            // Skip first day of the first week. It used as is (without modify)
            $weekday = $i > 0 ? $startDay->modify('+1 day') : $startDay;

            // Check if the date belongs to the months from $baseDate
            $isBaseMonth = $weekday->format('m') == $baseMonth;

            // Store week's day as array with assigned to it events (if ones exists)
            // 'valid' is indicate
            $week[] = [
                'date' => $weekday->format('j'),
                'events' => $isBaseMonth ? $this->getEventsForWeekDay($events, $weekday) : [],
                'valid' => $isBaseMonth,
                'today' => $weekday->format('j') === $today->format('j') && $weekday->format('m') === $today->format('m')
            ];
        }


        // Log::info('Week:' . $week);
        return $week;
    }
}
