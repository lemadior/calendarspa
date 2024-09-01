<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\EventDeleteRequest;
use App\Http\Requests\Calendar\EventEditRequest;
use App\Http\Requests\Calendar\EventsNewOrChangeRequest;
use App\Models\Calendar\Event;
use App\Models\User;
use App\Services\Calendar\DateService;
use App\Services\Calendar\EventService;
use Exception;
use Illuminate\Http\Request;
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
            $event = Event::create($data);
            $event->save();
            $user = auth()->user() ?? User::find(1);
            $user->events()->attach($event->id);
        } catch (Exception $err) {
            return redirect()->route(self::SHOW_DAY_ROUTE, ['date' => $eventDate])->with('error', $err->getMessage());
        }
        // dd($data);
        //  route('admin.calendar.showday', { date: dayDate, events: eventIds }) }
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
