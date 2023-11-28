<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

use function response;
use function trans;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'password' => Hash::make($request->validated('password')),
            ]);

            $user->assignRole('editor');

            return response()->json([
                'success' => true,
                'message' => trans('User created'),
                'user' => $user,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken(env('SECRET_TOKEN'));

            return response()->json([
                'message' => trans('User logged in'),
                'user' => $user,
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => trans('Invalid credentials'),
        ], Response::HTTP_FORBIDDEN);
    }
}
