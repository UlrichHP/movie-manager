<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreFormRequest;
use App\Models\Genre;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function array_merge;
use function response;
use function trans;

class GenreController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Genre::query();
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

    public function store(GenreFormRequest $request): JsonResponse
    {
        try {
            $genre = Genre::create(array_merge($request->validated(), [
                'user_id' => Auth::id(),
            ]));

            return response()->json([
                'success' => true,
                'message' => trans('Genre has been created'),
                'data' => $genre,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show(Genre $genre): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $genre,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(GenreFormRequest $request, Genre $genre): JsonResponse
    {
        if (! Auth::user()->hasRole('admin') && Auth::id() !== $genre->user_id) {
            return response()->json([
                'message' => trans('Unauthorized access'),
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $genre->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => trans('Genre has been updated'),
                'data' => $genre,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Genre $genre): JsonResponse
    {
        if (! Auth::user()->hasRole('admin') && Auth::id() !== $genre->user_id) {
            return response()->json([
                'message' => trans('Unauthorized access'),
            ], Response::HTTP_FORBIDDEN);
        }

        try {
            $genre->delete();

            return response()->json([
                'success' => true,
                'message' => trans('Genre has been deleted'),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
