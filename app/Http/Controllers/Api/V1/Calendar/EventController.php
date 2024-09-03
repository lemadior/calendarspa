<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Requests\Calendar\EventsNewOrChangeRequest;
use App\Http\Resources\Api\V1\Event\EventCreateResource;
use App\Http\Resources\Api\V1\Event\EventUpdateResource;
use App\Http\Resources\Api\V1\Event\EventShowResource;
use App\Http\Resources\Api\V1\Event\EventDeleteResource;
use App\Http\Controllers\Controller;
use App\Models\Calendar\Event;
use Illuminate\Http\Request;


/**
 * @OA\Get(
 *     path="/admin/event/{event}",
 *     operationId="event",
 *     summary="Get event data",
 *     description="Get all data for specified event",
 *     tags={"Event"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Event ID",
 *         in="path",
 *         name="event",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="4", value="4", summary="ID of specified event"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="event", type="array",
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
 *                     @OA\Property(property="action", type="string", example="Get event by ID", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * ),
 * @OA\Post(
 *     path="/admin/event",
 *     operationId="event_create",
 *     summary="Create new event",
 *     description="Create new event",
 *     tags={"Event"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="title", type="string", example="New Event"),
 *                     @OA\Property(property="start", type="string", example="14:15"),
 *                     @OA\Property(property="duration", type="string", example="00:30"),
 *                     @OA\Property(property="type_id", type="integer", example=1),
 *                     @OA\Property(property="status_id", type="integer", example=2),
 *                     @OA\Property(property="description", type="string", example="Event created by API"),
 *                     @OA\Property(property="date", type="string", example="2024-09-30")
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="status", type="string", example="success", description="Result of the creation"),
 *                     @OA\Property(property="event_id", type="integer", example=20, description="ID of newly created Event"),
 *                     @OA\Property(property="date", type="string", example="2024-09-30", description="Date of the creation")
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
 *                     @OA\Property(property="action", type="string", example="Create new event", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * )
 * @OA\Patch(
 *     path="/admin/event/{event}/edit",
 *     operationId="event_update",
 *     summary="Edit event",
 *     description="Edit existent event",
 *     tags={"Event"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Event ID",
 *         in="path",
 *         name="event",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="1", value="1", summary="ID of specified event"),
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="title", type="string", example="New Event"),
 *                     @OA\Property(property="start", type="string", example="14:15"),
 *                     @OA\Property(property="duration", type="string", example="00:30"),
 *                     @OA\Property(property="type_id", type="integer", example=1),
 *                     @OA\Property(property="status_id", type="integer", example=2),
 *                     @OA\Property(property="description", type="string", example="Event created by API"),
 *                     @OA\Property(property="date", type="string", example="2024-09-30")
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="status", type="string", example="success", description="Result of the creation"),
 *                     @OA\Property(property="event_id", type="integer", example=20, description="ID of newly created Event"),
 *                     @OA\Property(property="date", type="string", example="2024-09-30", description="Date of the creation")
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
 *                     @OA\Property(property="action", type="string", example="Update event by ID", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * ),
 * @OA\Delete(
 *     path="/admin/event/{event}",
 *     operationId="event_delete",
 *     summary="Delete event",
 *     description="Delete all data for specified event",
 *     tags={"Event"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Event ID",
 *         in="path",
 *         name="event",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="1", value="1", summary="ID of specified event"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="status", type="string", example="success", description="Result of the creation"),
 *                     @OA\Property(property="event_id", type="integer", example=20, description="ID of newly created Event"),
 *                     @OA\Property(property="date", type="string", example="2024-09-30", description="Date of the creation")
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
 *                     @OA\Property(property="action", type="string", example="Get event by ID", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * )
 */
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
