<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieFormRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Movie;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

use function array_merge;
use function response;
use function trans;

class MovieController extends Controller
{
    /**
     * @OA\GET(
     *     path="/api/movies",
     *     tags={"Movie"},
     *     summary="Get all movies",
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
     *     @OA\Parameter(
     *           name="title",
     *           in="query",
     *           description="Movie title",
     *           required=false,
     *
     *           @OA\Schema(type="string")
     *       ),
     *
     *     @OA\Parameter(
     *           name="genre",
     *           in="query",
     *           description="Genre name",
     *           required=false,
     *
     *           @OA\Schema(type="string")
     *       ),
     *
     *     @OA\Parameter(
     *           name="actor",
     *           in="query",
     *           description="Actor name",
     *           required=false,
     *
     *           @OA\Schema(type="string")
     *       ),
     *
     *     @OA\Response(response="200", description="Movies list paginated or filtered by title, genre or actor parameters"),
     * )
     */
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

    /**
     * @OA\GET(
     *     path="/api/movies/{movie}/show",
     *     tags={"Movie"},
     *     summary="Get a movie",
     *
     *     @OA\Parameter(
     *            name="movie",
     *            in="path",
     *            description="Movie id",
     *            required=true,
     *
     *            @OA\Schema(type="integer")
     *        ),
     *
     *     @OA\Response(response="200", description="Return movie details"),
     * )
     */
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
                ], Response::HTTP_FORBIDDEN);
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

    /**
     * @OA\Delete(
     *     path="/api/movies/{movie}/delete",
     *     security={{"bearerAuth":{}}},
     *     tags={"Movie"},
     *     summary="Delete a movie",
     *
     *     @OA\Parameter(
     *         name="movie",
     *         in="path",
     *         description="Movie id",
     *         required=true,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response="200", description="Movie has been deleted"),
     *     @OA\Response(response="403", description="Unauthorized access")
     * )
     */
    public function destroy(Movie $movie): JsonResponse
    {
        if (! Auth::user()->hasRole('admin') && Auth::id() !== $movie->user_id) {
            return response()->json([
                'message' => trans('Unauthorized access'),
            ], Response::HTTP_FORBIDDEN);
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
