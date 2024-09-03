<?php

namespace App\Http\Resources\Api\V1\Calendar;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Api\V1\Calendar\DataService;
use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
{
    protected DataService $dataService;

    protected $errorStatusCode = null;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->dataService = app(DataService::class);
    }

    // Return array of the Json data for error response
    public function prepareError(string $message, string $action): array
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
