<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

use App\Models\shopping;
use App\Http\Requests\StoreshoppingRequest;
use App\Http\Requests\UpdateshoppingRequest;
use MongoDB\BSON\ObjectId;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 20); // default 20
        $last_id = $request->input('last_id'); // expecting last_id

        $query = DB::table('shopping');

        if ($request->has('shopping_id')) {
            $shopping = $query->where('_id', new \MongoDB\BSON\ObjectId($request->shopping_id))->first();
            if ($shopping) {
                $shopping['id'] = (string) $shopping['_id'];
                if (isset($shopping['created_at']) && $shopping['created_at'] instanceof \MongoDB\BSON\UTCDateTime) {
                    $shopping['created_at'] = $shopping['created_at']->toDateTime()->format('Y-m-d H:i:s');
                } else {
                    $shopping['created_at'] = null; // Or set a default value
                }
                
                if (isset($shopping['updated_at']) && $shopping['updated_at'] instanceof \MongoDB\BSON\UTCDateTime) {
                    $shopping['updated_at'] = $shopping['updated_at']->toDateTime()->format('Y-m-d H:i:s');
                } else {
                    $shopping['updated_at'] = null; // Or set a default value
                }
                $shopping['createdate'] = (string) $shopping['createdate'];
                unset($shopping['_id']);
            }
            return response()->json(['error'=>false,'data' => $shopping,'code'=>200]);
        }

        
        // Apply last-based pagination
        if ($request->has('last_id')) {
            try {
                $lastId = new ObjectId($request->last_id);
                $query->where('_id', '>', $lastId);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Invalid last_id', 'code' => 400]);
            }
        }

        $shoppings = $query->orderBy('_id')->limit($limit)->get();
        $shoppings = $query->orderBy('_id')->limit($limit)->get()->map(function ($item) {
            $item['id'] = (string) $item['_id'];
            if (isset($item['created_at']) && $item['created_at'] instanceof \MongoDB\BSON\UTCDateTime) {
                $item['created_at'] = $item['created_at']->toDateTime()->format('Y-m-d H:i:s');
            } else {
                $item['created_at'] = null; // Or set a default value
            }
            
            if (isset($item['updated_at']) && $item['updated_at'] instanceof \MongoDB\BSON\UTCDateTime) {
                $item['updated_at'] = $item['updated_at']->toDateTime()->format('Y-m-d H:i:s');
            } else {
                $item['updated_at'] = null; // Or set a default value
            }
            $item['createdate'] = (string) $item['createdate'];
            unset($item['_id']);
            return $item;
        });

        $lastItem = $shoppings->last();
        $nextCursor = $lastItem && isset($lastItem['id'])
        ? (string) $lastItem['id']
        : null;
        return response()->json([
            'error' => false,
            'data' => $shoppings,
            'next_cursor' => $nextCursor,
            'code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'create_date' => 'required|date',
        ]);

        $data = $request->all();
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('shopping')->insert($data);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function show($id)
    {
        $item = DB::table('shopping')->where('_id', new ObjectId($id))->first();

        if (!$item || ($item->is_delete ?? false)) {
            return response()->json(['error' => true, 'message' => 'Item not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = DB::table('shopping')->where('_id', new ObjectId($id))->first();

        if (!$item || ($item->is_delete ?? false)) {
            return response()->json(['error' => true, 'message' => 'Item not found'], 404);
        }

        $data = $request->all();
        $data['updated_at'] = now();

        DB::table('shopping')->where('_id', new ObjectId($id))->update($data);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function destroy($id)
    {
        $item = DB::table('shopping')->where('_id', new ObjectId($id))->first();

        if (!$item) {
            return response()->json(['error' => true, 'message' => 'Item not found'], 404);
        }

        DB::table('shopping')->where('_id', new ObjectId($id))->update(['is_delete' => true]);

        return response()->json(['success' => true, 'message' => 'Item marked as deleted']);
    }
}
