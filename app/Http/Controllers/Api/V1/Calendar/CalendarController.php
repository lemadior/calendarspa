<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Calendar\CalendarResource;
use App\Http\Resources\Api\V1\Calendar\DayResource;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/admin/calendar?date=",
 *     operationId="calendar",
 *     summary="Get calendar data",
 *     description="Get all events for specified month",
 *     tags={"Calendar"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Calendar data",
 *         in="query",
 *         name="date",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         @OA\Examples(example="date=2024-09-30", value="2024-09-30", summary="Data of all months' events"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="month_data", type="array",
 *                         @OA\Items(
 *                             @OA\Property(property="id", type="integer", example="1", description="ID of the Event"),
 *                             @OA\Property(property="title", type="string", example="Title of the Event", description="Title of the Event"),
 *                             @OA\Property(property="start", type="string", example="10:30", description="Time when Event have to start"),
 *                             @OA\Property(property="duration", type="string", example="1:30", description="Duration of the Event (hrs)"),
 *                             @OA\Property(property="type_id", type="integer", example="1", description="ID of the Event's type"),
 *                             @OA\Property(property="status_id", type="integer", example="1", description="ID of the Event's status"),
 *                             @OA\Property(property="description", type="string", example="Event description", description="Short Description of the Event"),
 *                             @OA\Property(property="date", type="string", example="2024-09-04 18:16:00", description="The date to which the event is linked")
 *                         )
 *                     ),
 *                     @OA\Property(property="base_date", type="string", example="2024-08-31 02:10:11", description="Date of the month"),
 *                     @OA\Property(property="month", type="string", example="August", description="Month for displaying events"),
 *                     @OA\Property(property="year", type="string", example="2024", description="Year for displaying events"),
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad Request",
 *         @OA\JsonContent(
 *                 @OA\Property(property="error", type="string", example="Wrong request!")
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                     @OA\Property(property="action", type="string", example="resourse request", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Unauthorized", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                     @OA\Property(property="action", type="string", example="resourse request", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="resource not found", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Unprocessable Content",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="error", type="object",
 *                     @OA\Property(property="action", type="string", example="Get calendar data", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * ),
 * @OA\Get(
 *     path="/admin/calendar/day?date=",
 *     operationId="day_events",
 *     summary="Get events of the day",
 *     description="Get all events for specified day",
 *     tags={"Calendar"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Day data",
 *         in="query",
 *         name="date",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         @OA\Examples(example="date=2024-09-04", value="2024-09-04", summary="Data of all months' events"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="date", type="string", example="2024-09-04 02:10:11", description="Date of the day"),
 *                     @OA\Property(property="day", type="string", example="Wednesday", description="Day full name"),
 *                     @OA\Property(property="month_data", type="array",
 *                         @OA\Items(
 *                             @OA\Property(property="id", type="integer", example="1", description="ID of the Event"),
 *                             @OA\Property(property="title", type="string", example="Title of the Event", description="Title of the Event"),
 *                             @OA\Property(property="start", type="string", example="10:30", description="Time when Event have to start"),
 *                             @OA\Property(property="duration", type="string", example="1:30", description="Duration of the Event (hrs)"),
 *                             @OA\Property(property="type_id", type="integer", example="1", description="ID of the Event's type"),
 *                             @OA\Property(property="status_id", type="integer", example="1", description="ID of the Event's status"),
 *                             @OA\Property(property="description", type="string", example="Event description", description="Short Description of the Event"),
 *                             @OA\Property(property="date", type="string", example="2024-09-04 18:16:00", description="The date to which the event is linked")
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad Request",
 *         @OA\JsonContent(
 *                 @OA\Property(property="error", type="string", example="Wrong request!")
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                     @OA\Property(property="action", type="string", example="resourse request", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Unauthorized", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="object",
 *                     @OA\Property(property="action", type="string", example="resourse request", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="resource not found", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Unprocessable Content",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="error", type="object",
 *                     @OA\Property(property="action", type="string", example="Get event by day data", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * )
 */
class CalendarController extends Controller
{
    public function index(Request $request)
    {
        return new CalendarResource($request);
    }

    public function showDay(Request $request)
    {
        return new DayResource($request);
    }
}
