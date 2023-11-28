<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActorFormRequest;
use App\Models\Actor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function array_merge;
use function response;
use function trans;

class ActorController extends Controller
{
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
