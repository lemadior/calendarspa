<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\EventEditRequest;
use App\Http\Requests\Calendar\EventsNewOrChangeRequest;
use App\Models\Calendar\Event;
use App\Services\Calendar\DateService;
use App\Services\Calendar\EventService;
use Exception;
use Inertia\Inertia;

class EventController extends Controller
{
    const SHOW_DAY_ROUTE = 'admin.calendar.showday';

    protected DateService $dateService;
    protected EventService $eventService;

    public function __construct()
    {
        $this->dateService = app(DateService::class);
        $this->eventService = app(EventService::class);
    }

    public function create(EventsNewOrChangeRequest $request)
    {
        $data = $request->validated();
        $eventDate = $data['date'];

        $data['date'] = $this->dateService->getDate($eventDate);

        try {
            $this->eventService->createEvent($data);
        } catch (Exception $err) {
            return redirect()
                ->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])
                ->with('error', $err->getMessage());
        }

        return redirect()
            ->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])
            ->with('success', "The Event was created successfully");
    }


    public function update(Event $event, EventsNewOrChangeRequest $request)
    {
        $data = $request->validated();

        $eventDate = $this->dateService->getEventDate($event);

        try {
            $this->eventService->updateEvent($event, $data);
        } catch (Exception $err) {
            return redirect()
                ->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])
                ->with('error', $err->getMessage());
        }

        return redirect()
            ->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])
            ->with('success', "Event was update successfully");
    }



    public function delete(Event $event)
    {
        $eventDate = $this->dateService->getEventDate($event);

        try {
            $this->eventService->deleteEvent($event);
        } catch (Exception $err) {
            return redirect()
                ->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])
                ->with('error', $err->getMessage());
        }

        return redirect()
            ->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])
            ->with('success', "Event was deleted successfully");
    }
}
