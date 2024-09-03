<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Event\TypeDataResource;
use App\Http\Resources\Api\V1\Event\StatusDataResource;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/admin/event/type?id=0",
 *     operationId="types",
 *     summary="Get types List",
 *     description="Get all or single event type",
 *     tags={"Event"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Type ID",
 *         in="query",
 *         name="id",
 *         required=false,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="id=0", value="0", summary="Data of all event types"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example="1", description="Type ID"),
 *                     @OA\Property(property="name", type="string", example="General", description="Name of The Event Type"),
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
 *                     @OA\Property(property="action", type="string", example="Get event type data", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * ),
 * @OA\Get(
 *     path="/admin/event/status?id=0",
 *     operationId="statuses",
 *     summary="Get statuses List",
 *     description="Get all or single event status",
 *     tags={"Event"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Parameter(
 *         description="Status ID",
 *         in="query",
 *         name="id",
 *         required=false,
 *         @OA\Schema(type="integer"),
 *         @OA\Examples(example="id=0", value="0", summary="Data of all event statuses"),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Data array",
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example="1", description="Status ID"),
 *                     @OA\Property(property="name", type="string", example="Finished", description="Name of The Event Status"),
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
 *                     @OA\Property(property="action", type="string", example="Get event status data", description="name of the action where error is occurred"),
 *                     @OA\Property(property="message", type="string", example="Fail due to some errors", description="Error message if incoming parameters is wrong")
 *             )
 *         )
 *     )
 * )
 */
class DataController extends Controller
{
    public function getTypes(Request $request)
    {
        return new TypeDataResource($request);
    }

    public function getStatuses(Request $request)
    {
        return new StatusDataResource($request);
    }
}
