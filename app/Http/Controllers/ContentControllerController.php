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
            return response()->json(['error' => true, 'message' => 'Invalid type. Allowed: news, movie, shopping',
        ], 400);
        }

        $add_log = $this->logHit($type,$request->product_id,$request->user_id);

        return response()->json([
            'error' => false,
            'message' => $add_log,
        ], 201);
       
    }

    public function logHit($type, $productIds, $user_id)
    {
        try {
            $query = DB::table('jarp_log');
    
            // Check if already read
            $read = $query->where('product_id', $productIds)
                ->where('product_type', $type)
                ->where('user_id', $user_id)
                ->first();
    
            if ($read) {
                // Delete the record using Mongo ObjectId
                DB::table('jarp_log')->where('_id', new \MongoDB\BSON\ObjectId($read->_id))->delete();
    
                return response()->json([
                    'error' => false,
                    'message' => 'Read removed',
                ], 200);
            } else {
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
    
                return response()->json([
                    'error' => false,
                    'message' => 'Read added',
                ], 201);
            }
        } catch (\MongoDB\Driver\Exception\Exception $e) {
            // MongoDB specific exception
            return response()->json([
                'error' => true,
                'message' => 'MongoDB error: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // General PHP exception
            return response()->json([
                'error' => true,
                'message' => 'Error: ' . $e->getMessage(),
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
