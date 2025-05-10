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

    $news = $query->orderBy('_id')->limit($limit)->get();
    $lastItem = $news->last();

    $nextCursor = $lastItem && isset($lastItem['_id'])
    ? (string) $lastItem['_id']
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
