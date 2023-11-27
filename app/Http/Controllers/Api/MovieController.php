<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieFormRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Movie;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use function array_merge;
use function response;
use function trans;

class MovieController extends Controller
{
    public function index(SearchRequest $request): JsonResponse
    {
        $query = Movie::query()->with(['genres', 'actors']);

        if ($title = $request->validated('title')) {
            $query->where('title', 'like', "%$title%");
        }

        if ($genre = $request->validated('genre')) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('name', 'like', "%$genre%");
            });
        }

        if ($actor = $request->validated('actor')) {
            $query->whereHas('actors', function ($query) use ($actor) {
                $query->where('name', 'like', "%$actor%");
            });
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

    public function store(MovieFormRequest $request): JsonResponse
    {
        try {
            $movie = Movie::create(array_merge($request->validated(), [
                'user_id' => Auth::id(),
            ]));

            $movie->genres()->sync($request->validated('genres'));
            $movie->actors()->sync($request->validated('actors'));

            return response()->json([
                'success' => true,
                'message' => trans('Movie has been created'),
                'data' => $movie,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Movie::with(['genres', 'actors'])->find($id),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(MovieFormRequest $request, string $id): JsonResponse
    {
        try {
            /** @var Movie $movie */
            $movie = Movie::with(['genres', 'actors'])->find($id);

            if (! Auth::user()->hasRole('admin') && Auth::id() !== $movie->user_id) {
                return response()->json([
                    'message' => trans('Unauthorized access'),
                ], 403);
            }

            $movie->update($request->validated());

            $movie->genres()->sync($request->validated('genres'));
            $movie->actors()->sync($request->validated('actors'));

            return response()->json([
                'success' => true,
                'message' => trans('Movie has been updated'),
                'data' => $movie,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Movie $movie): JsonResponse
    {
        if (! Auth::user()->hasRole('admin') && Auth::id() !== $movie->user_id) {
            return response()->json([
                'message' => trans('Unauthorized access'),
            ], 403);
        }

        try {
            $movie->delete();

            return response()->json([
                'success' => true,
                'message' => trans('Movie has been deleted'),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
