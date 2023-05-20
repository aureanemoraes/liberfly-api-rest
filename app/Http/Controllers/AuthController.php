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

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request);

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request);

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data'], 201);
    }

    public function logout(): JsonResponse
    {
        $result = $this->authService->logout();

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }

    public function refresh(): JsonResponse
    {
        $result = $this->authService->refresh();

        if (!$result['success']) return response()->error($result['errors']);

        return response()->success($result['data']);
    }
}
