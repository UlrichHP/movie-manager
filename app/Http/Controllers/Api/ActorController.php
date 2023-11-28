<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActorFormRequest;
use App\Models\Actor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

use function array_merge;
use function response;
use function trans;

class ActorController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/actors",
     *     tags={"Actor"},
     *     summary="Get all actors",
     *
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number",
     *          required=false,
     *
     *          @OA\Schema(type="integer")
     *      ),
     *
     *     @OA\Response(response="200", description="Actors list paginated"),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Actor::query();
        $search = $request->input('search');

        if ($search !== null) {
            $query->where('name', 'like', "%$search%");
        }

        try {
            return response()->json([
                'success' => true,
                'data' => $query->paginate(3),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(ActorFormRequest $request): JsonResponse
    {
        try {
            $actor = Actor::create(array_merge($request->validated(), [
                'user_id' => Auth::id(),
            ]));

            return response()->json([
                'success' => true,
                'message' => trans('Actor has been created'),
                'data' => $actor,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/actors/{actor}/show",
     *     tags={"Actor"},
     *     summary="Get an actor",
     *
     *     @OA\Parameter(
     *            name="actor",
     *            in="path",
     *            description="Actor id",
     *            required=true,
     *
     *            @OA\Schema(type="integer")
     *        ),
     *
     *     @OA\Response(response="200", description="Return actor details"),
     * )
     */
    public function show(Actor $actor): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $actor,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(ActorFormRequest $request, Actor $actor): JsonResponse
    {
        if (! Auth::user()->hasRole('admin') && Auth::id() !== $actor->user_id) {
            return response()->json([
                'message' => trans('Unauthorized access'),
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $actor->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => trans('Actor has been updated'),
                'data' => $actor,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/actors/{actor}/delete",
     *     security={{"bearerAuth":{}}},
     *     tags={"Actor"},
     *     summary="Delete an actor",
     *
     *     @OA\Parameter(
     *         name="actor",
     *         in="path",
     *         description="Actor id",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response="200", description="Actor has been deleted"),
     *     @OA\Response(response="403", description="Unauthorized access")
     * )
     */
    public function destroy(Actor $actor): JsonResponse
    {
        if (! Auth::user()->hasRole('admin') && Auth::id() !== $actor->user_id) {
            return response()->json([
                'message' => trans('Unauthorized access'),
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $actor->delete();

            return response()->json([
                'success' => true,
                'message' => trans('Actor has been deleted'),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
