<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

/**
 * @OA\Info(
 *     title="Calendar Api",
 *     version="1.0"
 * ),
 * @OA\PathItem(
 *     path="/api"
 * ),
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer"
 *     )
 * ),
 * @OA\Server(
 *     url="http://localhost:5000/api"
 * )
 */
class HomeController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Home');
    }
}
