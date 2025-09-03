<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponse;

    /**
     * Authorization and create token.
     *
     * @param AuthRequest $authRequest
     *
     * @return JsonResponse
     */
    public function login(AuthRequest $authRequest): JsonResponse
    {
        $credentials = $authRequest->validated();

        if (!Auth::attempt($credentials)) {
            return $this->error('Unauthorized credential', 401);
        }

        $token = $authRequest->user()->createToken('tokenApi')->plainTextToken;

        return $this->success('Successful login', 200, ['token' => $token]);
    }

    /**
     * Logout and revoke token.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Successful logout', 200, ['token_revoke' => true]);
    }
}
