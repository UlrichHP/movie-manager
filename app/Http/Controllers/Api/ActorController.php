<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActorFormRequest;
use App\Models\Actor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function response;

class ActorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Actor::query();
        $search = $request->input('search');

        if (null !== $search) {
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
            $actor = Actor::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'L\'acteur(rice) a été créé',
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
        try {
            $actor->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'L\'acteur(rice) a été modifie',
                'data' => $actor,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Actor $actor): JsonResponse
    {
        try {
            $actor->delete();

            return response()->json([
                'success' => true,
                'message' => 'L\'acteur(rice) a été supprimé',
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
