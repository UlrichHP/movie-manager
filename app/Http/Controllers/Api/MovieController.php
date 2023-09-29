<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieFormRequest;
use App\Models\Movie;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function response;

class MovieController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Movie::query();
        $search = $request->input('search');

        if (null !== $search) {
            $query->where('title', 'like', "%$search%");
        }

        $result = $query->paginate(3);

        try {
            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(MovieFormRequest $request): JsonResponse
    {
        try {
            $movie = Movie::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Le film a été créé',
                'data' => $movie,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show(Movie $movie): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $movie,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(MovieFormRequest $request, Movie $movie): JsonResponse
    {
        try {
            $movie->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Le film a été modifie',
                'data' => $movie,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Movie $movie): JsonResponse
    {
        try {
            $movie->delete();

            return response()->json([
                'success' => true,
                'message' => 'Le film a été supprimé',
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
