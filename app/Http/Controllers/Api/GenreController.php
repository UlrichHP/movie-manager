<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreFormRequest;
use App\Models\Genre;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function array_merge;
use function response;

class GenreController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Genre::query();
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

    public function store(GenreFormRequest $request): JsonResponse
    {
        try {
            $genre = Genre::create(array_merge($request->validated(), [
                'user_id' => Auth::id(),
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Le genre a été créé',
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
        if (Auth::id() !== $genre->user_id) {
            return response()->json([
                'message' => 'Accès non autorisé'
            ], 403);
        }

        try {
            $genre->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Le genre a été modifie',
                'data' => $genre,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy(Genre $genre): JsonResponse
    {
        if (Auth::id() !== $genre->user_id) {
            return response()->json([
                'message' => 'Accès non autorisé'
            ], 403);
        }

        try {
            $genre->delete();

            return response()->json([
                'success' => true,
                'message' => 'Le genre a été supprimé',
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
