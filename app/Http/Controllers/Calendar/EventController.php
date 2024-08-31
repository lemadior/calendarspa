<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Requests\Calendar\EventDeleteRequest;
use App\Http\Requests\Calendar\EventEditRequest;
use App\Http\Requests\Calendar\EventsNewOrChangeRequest;
use App\Models\Calendar\Event;
use App\Models\User;
use App\Services\Calendar\DateService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    protected DateService $dateService;

    public function __construct()
    {
        $this->dateService = app(DateService::class);
    }


    public function edit(Event $event, EventEditRequest $request)
    {
        $data = $request->validated();
        $data['event'] = $event;
        // dd($data);
        return Inertia::render('Calendar/Event', ['action' => 'edit', 'data' => $data]);
    }

    public function create(EventEditRequest $request)
    {
        $data = $request->validated();
        // $data['event'] = $event;
        // dd($data);
        return Inertia::render('Calendar/Event', ['action' => 'create', 'data' => $data]);
    }

    public function update(Event $event, EventsNewOrChangeRequest $request)
    {
        $data = $request->validated();
        $eventId = $event->id;
        $eventDate = explode(' ', $event->date)[0];
        // $data['event'] = $event;
        // dd($data);
        try {
            $event->update($data);
            $event->refresh();
        } catch (Exception $err) {
            return redirect()->route('admin.calendar.showday', ['date' => $eventDate])->with('error', $err->getMessage());
        }
        //  route('admin.calendar.showday', { date: dayDate, events: eventIds }) }
        return redirect()->route('admin.calendar.showday', ['date' => $eventDate])->with('success', "Event was update successfully");
    }

    public function store(EventsNewOrChangeRequest $request)
    {
        $data = $request->validated();
        $eventDate = $data['date'];
        // $eventDate = '2024-01-09';
        // $data['event'] = $event;
        $data['date'] = $this->dateService->getDate($eventDate);
        try {
            $event = Event::create($data);
            $event->save();
            $user = auth()->user() ?? User::find(1);
            $user->events()->attach($event->id);
        } catch (Exception $err) {
            return redirect()->route('admin.calendar.showday', ['date' => $eventDate])->with('error', $err->getMessage());
        }
        // dd($data);
        //  route('admin.calendar.showday', { date: dayDate, events: eventIds }) }
        return redirect()->route('admin.calendar.showday', ['date' => $eventDate])->with('success', "The Event was created successfully");
    }

    public function delete(Event $event)
    {
        // $data = $request->validated();
        $eventDate = explode(' ', $event->date)[0];
        // dd($event, $eventDate);
        try {
            $event->delete();
        } catch (Exception $err) {
            return redirect()->route('admin.calendar.showday', ['date' => $eventDate])->with('error', $err->getMessage());
        }
        //  route('admin.calendar.showday', { date: dayDate, events: eventIds }) }
        return redirect()->route('admin.calendar.showday', ['date' => $eventDate])->with('success', "Event was deleted successfully");
    }
}
