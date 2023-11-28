<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreFormRequest;
use App\Models\Genre;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

use function array_merge;
use function response;
use function trans;

class GenreController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/genres",
     *     tags={"Genre"},
     *     summary="Get all genres",
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
     *     @OA\Response(response="200", description="Genres list paginated"),
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/genres/create",
     *     security={{"bearerAuth":{}}},
     *     tags={"Genre"},
     *     summary="Create a genre",
     *
     *     @OA\RequestBody(
     *      required=true,
     *
     *      @OA\MediaType(
     *        mediaType="application/json",
     *
     *        @OA\Schema(
     *
     *          @OA\Property(
     *            property="name",
     *            description="Genre name",
     *            type="string"
     *          ),
     *        ),
     *      ),
     *    ),
     *
     *     @OA\Response(response="200", description="Genre has been created")
     * )
     */
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

    /**
     * @OA\GET(
     *     path="/api/genres/{genre}/show",
     *     tags={"Genre"},
     *     summary="Get an actor",
     *
     *     @OA\Parameter(
     *            name="genre",
     *            in="path",
     *            description="Genre id",
     *            required=true,
     *
     *            @OA\Schema(type="integer")
     *        ),
     *
     *     @OA\Response(response="200", description="Return genre details")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/genres/{genre}/delete",
     *     security={{"bearerAuth":{}}},
     *     tags={"Genre"},
     *     summary="Delete a genre",
     *
     *     @OA\Parameter(
     *         name="genre",
     *         in="path",
     *         description="Genre id",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response="200", description="Genre has been deleted"),
     *     @OA\Response(response="403", description="Unauthorized access")
     * )
     */
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
