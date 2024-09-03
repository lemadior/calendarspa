<?php

namespace App\Http\Resources\Api\V1\Calendar;

use App\Http\Resources\Api\V1\DataResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DayResource extends DataResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $validation = Validator::make($request->all(), [
            'date' => 'required|string|date_format:Y-m-d',
        ]);

        if ($validation->fails()) {
            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return  $this->prepareError('Get event by day data', $validation->errors());
        }

        $data = $validation->validated();


        $day = $this->dateService->getFullNameOfDay($data['date']);

        $events = $this->eventService->getEventsByDate($data['date']);

        return [
            'date' => $data['date'],
            'day' => $day,
            'events' => $events
        ];
    }
}
