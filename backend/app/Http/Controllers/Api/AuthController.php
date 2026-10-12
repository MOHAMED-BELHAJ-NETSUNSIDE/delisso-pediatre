<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $provider = Auth::createUserProvider('users');
        $user = $provider->retrieveByCredentials($data);
        if (! $user instanceof User || ! $user->active || ! $provider->validateCredentials($user, $data)) {
            return response()->json(['error' => 'Identifiants invalides'], 401);
        }

        return response()->json([
            'token' => $user->createToken('mobile')->plainTextToken,
            'user' => $user->toApi(),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->toApi(withMeta: true),
        ]);
    }
}
