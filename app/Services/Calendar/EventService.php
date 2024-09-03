<?php

namespace App\Services\Calendar;

use App\Models\Calendar\Event;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Services\Calendar\DateService;
use DateTime;
use Exception;


class EventService
{
    // Authenticated user
    protected Authenticatable|User|null $user;

    protected DateService $dateService;

    public function __construct()
    {
        $this->user = auth()->user() ?? false; // TODO remove false condition after adding JWT token
        $this->dateService = app(DateService::class);
    }

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
        if (!$this->user) {
            return new Collection();
        }

        $baseYear = $baseDate->format('Y');
        $baseMonth = $baseDate->format('m');

        $events = User::find($this->user->id)?->events()
            ->whereYear('date', $baseYear)
            ->whereMonth('date', $baseMonth);

        return $events->select('event_id', 'title', 'start', 'duration', 'type_id', 'status_id', 'description', 'date')->get();
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

        // Get events depends on month from $baseDate
        $events = $this->getEvents($baseDate);

        $startDay = $this->dateService->getFirstDayOfFirstWeek($baseDate);

        $startWeek = $weekNumber - 1;

        $startDay->modify('+' . $startWeek . ' week');

        for ($i = 0; $i <= 6; $i++) {

            // Skip first day of the first week. It used as is (without modify)
            $weekday = $i > 0 ? $startDay->modify('+1 day') : $startDay;

            // Check if the date belongs to the months from $baseDate
            $isBaseMonth = $weekday->format('m') == $baseMonth;

            // Store week's day as array with assigned to it events (if ones exists)
            // 'valid' is indicate that date is belongs to the current Month
            $week[] = [
                'date' => $weekday->format('j'),
                'events' => $isBaseMonth ? $this->getEventsForWeekDay($events, $weekday) : [],
                'valid' => $isBaseMonth,
                'today' => $weekday->format('j') === $today->format('j') && $weekday->format('m') === $today->format('m')
            ];
        }

        return $week;
    }

    // The $date must be in format 'YYYY-mm-dd'
    public function getEventsByDate(string $date)
    {
        return User::find($this->user->id)?->events()
            ->whereDate('date', $date)
            ->selectRaw('event_id as id')
            ->addSelect('title', 'start', 'duration', 'type_id', 'status_id', 'description', 'date')
            ->get();
    }

    // The $date must be in format 'YYYY-mm-dd'
    public function getEventByID(int $eventId)
    {
        return Event::where('id', $eventId)
            ->select('id', 'title', 'start', 'duration', 'type_id', 'status_id', 'description', 'date')
            ->get();
    }

    // Add new Event
    public function createEvent(array $data): Event
    {
        try {
            $event = Event::create($data);
            $event->save();

            $this->user->events()->attach($event->id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }

        return $event;
    }

    // Edit the Event
    public function updateEvent(Event $event, array $eventData): Event
    {
        try {
            $event->update($eventData);
            $event->refresh();
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }

        return $event;
    }

    // Delete the Event
    public function deleteEvent(Event $event): int
    {
        $eventId = $event->id;

        try {
            $event->delete();
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }

        return $eventId;
    }
}
