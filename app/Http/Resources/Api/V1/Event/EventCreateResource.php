<?php

namespace App\Http\Resources\Api\V1\Event;

use App\Http\Resources\Api\V1\DataResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

class EventCreateResource extends DataResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|min:1',
            'start' => 'required|string|date_format:H:i',
            'duration' => 'required',
            'type_id' => 'required',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'date' => 'nullable|string|date_format:Y-m-d|after_or_equal:today'
        ]);

        if ($validation->fails()) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Create new event', $validation->errors());
        }

        $data = $validation->validated();

        $eventDate = $data['date'];

        $data['date'] = $this->dateService->getDate($eventDate);

        try {
            $event = $this->eventService->createEvent($data);
        } catch (Exception $err) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Create new event', $err->getMessage());
        }

        return [
            'status' => 'success',
            'event_id' => $event->id,
            'date' => $eventDate
        ];
    }
}
