<?php

namespace App\Http\Resources\Api\V1\Event;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Api\V1\DataResource;

class EventShowResource extends DataResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $event = $this->resource;

        try {
            $eventId = $event->id;
        } catch (Exception $err) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Get event by ID', $err->getMessage());
        }

        try {
            $eventData = $this->eventService->getEventByID($eventId)->toArray();
        } catch (Exception $err) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Get event by ID', $err->getMessage());
        }
        // dd($eventData->toArray());
        return ['event' => $eventData[0]];
    }
}
