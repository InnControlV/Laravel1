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

        $validator = Validator::make($request->all(), [
            'product_type' => 'required|string|in:news,movie,shopping',
            'product_id' => 'required',
            'user_id' => 'required',
        ]);
    
        // If validation fails, return errors
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


        $query = DB::table('bookmarks');
        $bookmark = $query->where('product_id',$request->product_id)
        ->where('product_type',$request->product_type)
        ->where('user_id',$request->user_id)
        ->first();

        if($bookmark){
            DB::table('bookmarks')->where('_id', new \MongoDB\BSON\ObjectId($bookmark['_id']))->delete();

            return response()->json([
                'error' => false,
                'message' => 'Bookmark delete successfully.',
            ], 201);
        }


        $id = DB::table('bookmarks')->insertGetId($data);
      
        return response()->json([
            'error' => false,
            'message' => 'Bookmark added successfully.',
        ], 201);
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
