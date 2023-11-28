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
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

use function response;
use function trans;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register an user",
     *
     *     @OA\RequestBody(
     *       required=true,
     *
     *       @OA\MediaType(
     *         mediaType="application/json",
     *
     *         @OA\Schema(
     *
     *           @OA\Property(
     *             property="name",
     *             description="User name",
     *             type="string"
     *           ),
     *           @OA\Property(
     *              property="email",
     *              description="User email",
     *              type="string"
     *            ),
     *            @OA\Property(
     *               property="password",
     *               description="User password",
     *               type="string"
     *             ),
     *         ),
     *       ),
     *     ),
     *
     *     @OA\Response(response="201", description="User created"),
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Authenticate user and generate JWT token",
     *
     *     @OA\RequestBody(
     *        required=true,
     *
     *        @OA\MediaType(
     *          mediaType="application/json",
     *
     *          @OA\Schema(
     *
     *            @OA\Property(
     *               property="email",
     *               description="User email",
     *               type="string"
     *             ),
     *              @OA\Property(
     *                property="password",
     *                description="User password",
     *                type="string"
     *              ),
     *          ),
     *        ),
     *      ),
     *
     *     @OA\Response(response="200", description="User logged in"),
     *     @OA\Response(response="403", description="Invalid credentials")
     * )
     */
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
