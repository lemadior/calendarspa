<?php

namespace App\Http\Resources\Api\V1\Calendar;

use App\Http\Resources\Api\V1\Calendar\DataResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;


class TypeDataResource extends DataResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $typeId = $request->query('id');

        $codeType = Response::HTTP_UNPROCESSABLE_ENTITY;

        try {
            $data = $this->dataService->getTypes($typeId);
            $result = $data->toArray();

            if (!count($result)) {
                $codeType = Response::HTTP_NOT_FOUND;

                $result =  $this->prepareError('Get event type data', 'Event type not found');

                throw new Exception('Event type not found');
            }
        } catch (Exception $err) {
            $result =  $this->prepareError('Get event type data', $err->getMessage());

            $this->errorStatusCode = $codeType;
        }

        return $result;
    }
}
