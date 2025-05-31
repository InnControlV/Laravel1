<?php

namespace App\Http\Controllers;

use App\Models\ContentController;
use App\Http\Requests\StoreContentControllerRequest;
use App\Http\Requests\UpdateContentControllerRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
class ContentControllerController extends Controller
{


    public function read(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_type' => 'required',
                'user_id' => 'required',
                'product_id' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()->first(),
                    'code' => 422
                ], 422);
            }
    
            $type = $request->product_type;
            $allowedTypes = ['news', 'movie', 'shopping'];
    
            if (!in_array($type, $allowedTypes)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid type. Allowed: news, movie, shopping',
                    'code' => 400
                ], 400);
            }
    
            // Call logHit in try-catch to handle DB errors inside that method
            $add_log = $this->logHit($type, $request->product_id, $request->user_id);
    
            return response()->json([
                'error' => false,
                'message' => $add_log,
                'code' => 201
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Unexpected error: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    
    public function logHit($type, $productIds, $user_id)
    {
        try {
            $query = DB::table('jarp_log');
    
            try {
                // Check if already read
                $read = $query->where('product_id', $productIds)
                    ->where('product_type', $type)
                    ->where('user_id', $user_id)
                    ->first();
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to fetch log: ' . $e->getMessage(),
                    'code' => 500
                ], 500);
            }
    
            if ($read) {
                try {
                    // Delete the record using Mongo ObjectId
                    DB::table('jarp_log')->where('_id', new \MongoDB\BSON\ObjectId($read->_id))->delete();
                } catch (\Exception $e) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Failed to delete log: ' . $e->getMessage(),
                        'code' => 500
                    ], 500);
                }
    
                return response()->json([
                    'error' => false,
                    'message' => 'Read removed',
                    'code' => 200
                ], 200);
            } else {
                try {
                    // Insert new read log
                    DB::table('jarp_log')->insert([
                        'product_type' => $type,
                        'product_id' => $productIds,
                        'count' => 1,
                        'user_id' => $user_id,
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->header('User-Agent'),
                        'hit_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Failed to insert log: ' . $e->getMessage(),
                        'code' => 500
                    ], 500);
                }
    
                return response()->json([
                    'error' => false,
                    'message' => 'Read added',
                    'code' => 201
                ], 201);
            }
        } catch (\MongoDB\Driver\Exception\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'MongoDB error: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
    

    private function convertTimestamps(&$item)
    {
        if (isset($item['created_at']) && $item['created_at'] instanceof UTCDateTime) {
            $item['created_at'] = $item['created_at']->toDateTime()->format('Y-m-d H:i:s');
        }

        if (isset($item['updated_at']) && $item['updated_at'] instanceof UTCDateTime) {
            $item['updated_at'] = $item['updated_at']->toDateTime()->format('Y-m-d H:i:s');
        }
    }


}
