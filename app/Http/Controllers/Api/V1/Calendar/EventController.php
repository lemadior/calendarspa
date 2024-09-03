<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Requests\Calendar\EventsNewOrChangeRequest;
use App\Http\Resources\Api\V1\Event\EventCreateResource;
use App\Http\Resources\Api\V1\Event\EventUpdateResource;
use App\Http\Resources\Api\V1\Event\EventShowResource;
use App\Http\Resources\Api\V1\Event\EventDeleteResource;
use App\Http\Controllers\Controller;
use App\Models\Calendar\Event;


class EventController extends Controller
{
    public function show(Event $event)
    {
        return new EventShowResource($event);
    }

    public function create(EventsNewOrChangeRequest $request)
    {
        return new EventCreateResource($request);
    }


    public function update(Event $event)
    {
        return new EventUpdateResource($event);
    }

    public function delete(Event $event)
    {
        return new EventDeleteResource($event);
    }
}
