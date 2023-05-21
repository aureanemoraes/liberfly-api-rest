<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authService = new AuthService();

    }

    /**
    * @OA\Post(
    *     path="/api/login",
    *     summary="User Login",
    *     tags={"Authentication"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="email", type="string", format="email", example="liberfly@test.com"),
    *             @OA\Property(property="password", type="string", format="password", example="!liberfly!")
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful login",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="data", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="Unauthorized",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    *     @OA\Response(
    *         response="422",
    *         description="Unprocessable Content",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    * )
    */

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request);

        if (!$result['success']) return response()->error($result['errors'], 401);

        return response()->success($result['data']);
    }

    /**
    * @OA\Post(
    *     path="/api/register",
    *     summary="User Registration",
    *     tags={"Authentication"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="name", type="string"),
    *             @OA\Property(property="email", type="string", format="email"),
    *             @OA\Property(property="password", type="string", format="password")
    *         )
    *     ),
    *     @OA\Response(
    *         response="201",
    *         description="Successful registration",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="data", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    *     @OA\Response(
    *         response="422",
    *         description="Unprocessable Content",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    * )
    */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request);

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data'], 201);
    }

    /**
    * @OA\Post(
    *     path="/api/logout",
    *     summary="User Logout",
    *     tags={"Authentication"},
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="token",
    *         in="query",
    *         description="Bearer token",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful logout",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="data", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    * )
    */
    public function logout(): JsonResponse
    {
        $result = $this->authService->logout();

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }

    /**
    * @OA\Post(
    *     path="/api/refresh",
    *     summary="User refresh",
    *     tags={"Authentication"},
    *     security={{ "bearerAuth": {} }},
    *     @OA\Parameter(
    *         name="token",
    *         in="query",
    *         description="Bearer token",
    *         required=true,
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful refresh",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean"),
    *             @OA\Property(property="data", type="object"),
    *             @OA\Property(property="message", type="string"),
    *         )
    *     ),
    * )
    */
    public function refresh(): JsonResponse
    {
        $result = $this->authService->refresh();

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }
}
