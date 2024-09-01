<?php

namespace App\Http\Controllers\Calendar;

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


    public function edit(Event $event, EventEditRequest $request)
    {
        $data = $request->validated();

        $data['event'] = $event;

        $data['isExpired'] = (bool)$data['isExpired'];

        return Inertia::render('Calendar/Event', ['action' => 'edit', 'data' => $data]);
    }

    public function create(EventEditRequest $request)
    {
        $data = $request->validated();

        return Inertia::render('Calendar/Event', ['action' => 'create', 'data' => $data]);
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

    public function store(EventsNewOrChangeRequest $request)
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
