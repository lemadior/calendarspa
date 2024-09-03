<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Api\V1\Calendar\DataService;
use App\Services\Calendar\DateService;
use App\Services\Calendar\EventService;
use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
{
    protected DataService $dataService;

    protected DateService $dateService;

    protected EventService $eventService;

    protected $errorStatusCode = null;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->dataService = app(DataService::class);
        $this->eventService = app(EventService::class);
        $this->dateService = app(DateService::class);
    }

    // Return array of the Json data for error response
    public function prepareError(string $action, string $message): array
    {
        return [
            'error' => [
                'action' => $action,
                'message' => $message
            ]
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->header('Content-Type', 'application/json');

        if ($this->errorStatusCode) {
            $response->setStatusCode($this->errorStatusCode);
        }
    }
}
