<?php

namespace App\Http\Controllers;

use App\Models\movie;
use App\Http\Requests\StoremovieRequest;
use App\Http\Requests\UpdatemovieRequest;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->query('location');
        $query = DB::table('movies');

        if ($request->has('movie_id')) {
            $movies = $query->where('_id', new \MongoDB\BSON\ObjectId($request->movie_id))->first(); 
            return response()->json(['error'=>false,'data' => $movies,'code'=>200]);
        }

        if ($location) {
            $query->where('location', $location);
        }

        $limit = $request->input('limit', 20);

        if ($request->has('last_id')) {
            try {
                $lastId = new ObjectId($request->last_id);
                $query->where('_id', '>', $lastId);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Invalid last_id', 'code' => 400]);
            }
        }
    
        $movie = $query->orderBy('_id')->limit($limit)->get();
        $lastItem = $movie->last();
    
        $nextCursor = $lastItem && isset($lastItem['_id'])
        ? (string) $lastItem['_id']
        : null;
    
        return response()->json([
            'error' => false,
            'data' => $movie,
            'next_cursor' => $nextCursor,
            'code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'release_date' => 'required|date',
            'language' => 'required|string',
            'refer_from' => 'nullable|string',
        ]);

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table('movies')->insertGetId($validated);

        $movie = DB::table('movies')->where('id', $id)->first();

        return response()->json(['success' => true, 'movie' => $movie], 201);
    }

    public function show($id)
    {
        $movie = DB::table('movies')->where('id', $id)->first();

        if (!$movie) {
            return response()->json(['error' => true, 'message' => 'Movie not found'], 404);
        }

        return response()->json($movie);
    }

    public function update(Request $request, $id)
    {
        $movie = DB::table('movies')->where('id', $id)->first();

        if (!$movie) {
            return response()->json(['error' => true, 'message' => 'Movie not found'], 404);
        }

        DB::table('movies')->where('id', $id)->update([
            'title' => $request->input('title', $movie->title),
            'location' => $request->input('location', $movie->location),
            'release_date' => $request->input('release_date', $movie->release_date),
            'language' => $request->input('language', $movie->language),
            'refer_from' => $request->input('refer_from', $movie->refer_from),
            'updated_at' => now(),
        ]);

        $updatedMovie = DB::table('movies')->where('id', $id)->first();

        return response()->json(['success' => true, 'movie' => $updatedMovie]);
    }

    public function destroy($id)
    {
        $movie = DB::table('movies')->where('id', $id)->first();

        if (!$movie) {
            return response()->json(['error' => true, 'message' => 'Movie not found'], 404);
        }

        DB::table('movies')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Movie deleted']);
    }
}
