<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\ObjectId;


class NewsController extends Controller
{


    public function indexShow(Request $request){
        $perPage = $request->input('paginate', 20);  // You can change the default value to your needs

        // Fetch paginated news items using DB::table
        $news = DB::table('news')
            ->orderBy('created_at', 'desc')  // Ordering by created_at as an example
            ->paginate($perPage);    
        // Return the view with the paginated news data
        return view('news.index', compact('news'));
    }


    public function index(Request $request)
    {
        $query = DB::table('news');

        if ($request->has('news_id')) {
            $news = $query->where('_id', new \MongoDB\BSON\ObjectId($request->news_id))->first();
            if ($news) {
                $news['id'] = (string) $news['_id'];
                if (isset($news['created_at']) && $news['created_at'] instanceof \MongoDB\BSON\UTCDateTime) {
                    $news['created_at'] = $news['created_at']->toDateTime()->format('Y-m-d H:i:s');
                } else {
                    $news['created_at'] = null; // Or set a default value
                }
                
                if (isset($news['updated_at']) && $news['updated_at'] instanceof \MongoDB\BSON\UTCDateTime) {
                    $news['updated_at'] = $news['updated_at']->toDateTime()->format('Y-m-d H:i:s');
                } else {
                    $news['updated_at'] = null; // Or set a default value
                }
                unset($news['_id']);
            }
            return response()->json(['error'=>false,'data' => $news,'code'=>200]);
        }

        if ($request->has('language')) {
            $query->where('language', $request->language);
        }

        if ($request->has('location')) {
            $query->where('location', $request->location);
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

    $news = $query->orderBy('_id')->limit($limit)->get()->map(function ($item) {
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
        unset($item['_id']);
        return $item;
    });

    $lastItem = $news->last();

    $nextCursor = $lastItem && isset($lastItem['id'])
    ? (string) $lastItem['id']
    : null;

    return response()->json([
        'error' => false,
        'data' => $news,
        'next_cursor' => $nextCursor,
        'code' => 200
    ]);
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'short_description' => 'required',
            'details' => 'required',
            'language' => 'required',
            'location' => 'required',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $news = News::create($request->all());

        return response()->json(['message' => 'News created successfully', 'data' => $news], 201);
    }
}
