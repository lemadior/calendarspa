<?php

namespace App\Http\Resources\Api\V1\Event;

use App\Http\Resources\Api\V1\DataResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

class EventDeleteResource extends DataResource
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
            $eventDate = $this->dateService->getEventDate($event);
            $eventId = $event->id;
        } catch (Exception $err) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Delete event by ID', $err->getMessage());
        }

        try {
            $this->eventService->deleteEvent($event);
        } catch (Exception $err) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Delete event by ID', $err->getMessage());
        }

        return [
            'status' => 'success',
            'date' => $eventDate,
            'event_id' => $eventId
        ];
    }
}
