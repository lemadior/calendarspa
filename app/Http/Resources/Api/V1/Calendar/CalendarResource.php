<?php

namespace App\Http\Resources\Api\V1\Calendar;

use App\Http\Resources\Api\V1\DataResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;


class CalendarResource extends DataResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $monthData = [];
        $dateValue = $request->query('date') ?? null;
        $isFetchFromComponent = $request->query('fetch') ?? false;

        try {
            $incomingDate = $this->checkDate($dateValue);

            for ($i = 1; $i <= 6; $i++) {
                $monthData[] = $this->eventService->getDaysWithEventsByWeek($incomingDate, $i);
            }

            $date = $this->dateService->getDate($incomingDate);

            $result = [
                'month_data' => $this->scrubMonthData($monthData, $isFetchFromComponent),
                'base_date' => $incomingDate,
                'month' => $date->format('F'),
                'year' => $date->format('Y')
            ];
        } catch (Exception $err) {
            $result =  $this->prepareError('Get calendar data', $err->getMessage());

            $this->errorStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return $result;
    }

    // Check date for incoming value. Possible values: null, 'Y-m-d', 'Y-m-d H:i:s', 'Y-m-dTH:i:s.msZ'
    protected function checkDate(string|null $date): string
    {
        if (!empty($date) && strpos($date, 'T')) {
            return $this->dateService->scrubDate($date);
        }

        return $date ?? Carbon::now(config('app.timezone'))->format('Y-m-d');
    }

    // Remove some of the Event attributes (not needed for API)
    protected function scrubMonthData(array $monthData, bool $isFetch = false): array
    {
        $_monthData = $monthData;

        foreach ($_monthData as $wkey => $week) {

            foreach ($week as $dkey => $day) {

                if (!$isFetch) {
                    unset($monthData[$wkey][$dkey]['valid']);
                    unset($monthData[$wkey][$dkey]['today']);
                }

                foreach ($day['events'] as $ekey => $event) {
                    $_event = $event->toArray();
                    $_event = array_merge(['id' => $_event['event_id']], $_event);

                    unset($_event['pivot']);
                    unset($_event['event_id']);

                    $monthData[$wkey][$dkey]['events'][$ekey] = $_event;
                }
            }
        }

        return $monthData;
    }
}
