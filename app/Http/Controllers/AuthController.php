<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Post(
 *     path="/auth/login",
 *     operationId="authUser",
 *     summary="Get token to works with API for admin tasks",
 *     description="Get token for existent user",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", example="test@example.com"),
 *                     @OA\Property(property="password", type="string", example="password"),
 *                )
 *             }
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(description="Current token",
 *             @OA\Property(property="token", type="string", example="<token>", description="Admin Authentication Token"),
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
 *         response="404",
 *         description="Resource not found"
 *     )
 * )
 */
class AuthController extends Controller
{
    /**
     * Get User Token (used for switching Month or Year for Calendar Page)
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getUserToken(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['token' => ''], 401);
        }

        // JWT-token generation
        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
