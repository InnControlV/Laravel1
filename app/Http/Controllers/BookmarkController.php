<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    // Create a new bookmark
    public function create(Request $request)
    {
        try {
            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'product_type' => 'required|string|in:news,movie,shopping',
                'product_id' => 'required',
                'user_id' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->first(),
                    'code' => 422
                ], 422);
            }
    
            $data = [
                'user_id' => $request->user_id,
                'product_type' => $request->product_type,
                'product_id' => $request->product_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
    
            $query =  DB::table('bookmarks');
            $bookmark = $query->where('product_id', $request->product_id)
                ->where('product_type', $request->product_type)
                ->where('user_id', $request->user_id)
                ->first();

                $id = (string) $bookmark['_id'];
            if ($bookmark) {
                // Note: Replace _id with your actual primary key if it's not MongoDB
                DB::table('bookmarks')
                    ->where('_id', $id) // or '_id' if using Mongo
                    ->delete();
    
                return response()->json([
                    'error' => false,
                    'message' => 'Bookmark deleted successfully.',
                    'code' => 200
                ], 200);
            }
    
            DB::table('bookmarks')->insert($data);
    
            return response()->json([
                'error' => false,
                'message' => 'Bookmark added successfully.',
                'code' => 201
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => 'Database error: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Unexpected error: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    

    // Delete a bookmark
    public function delete($id)
    {
        $bookmark = DB::table('bookmarks')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$bookmark) {
            return response()->json([
                'error' => true,
                'message' => 'Bookmark not found.',
            ], 404);
        }

        DB::table('bookmarks')->where('id', $id)->delete();

        return response()->json([
            'error' => false,
            'message' => 'Bookmark deleted successfully.',
        ]);
    }

    // Get all bookmarks for the authenticated user
    public function index()
    {
        $bookmarks = DB::table('bookmarks')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'error' => false,
            'data' => $bookmarks
        ]);
    }
}
