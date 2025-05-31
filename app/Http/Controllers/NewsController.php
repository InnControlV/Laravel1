<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\ObjectId;


class NewsController extends Controller
{


    public function check(Request $request){
        return view('news.index', compact('news'));

    }

    public function indexShow(Request $request){
        $perPage = $request->input('paginate', 20);  // You can change the default value to your needs

        // Fetch paginated news items using DB::table
        $news = DB::table('news')
            ->orderBy('created_at', 'desc')  // Ordering by created_at as an example
            ->paginate($perPage);    
        // Return the view with the paginated news data
        return view('news.index', compact('news'));
    }


    // public function index(Request $request)
    // {
    //     $query = DB::table('news');
    //     $user_id = $request->user_id;

    //     if ($request->has('news_id')) {
    //         $news = $query->where('_id', new \MongoDB\BSON\ObjectId($request->news_id))->first();
    //         if ($news) {
    //             $news['id'] = (string) $news['_id'];
    //             if (isset($news['created_at']) && $news['created_at'] instanceof \MongoDB\BSON\UTCDateTime) {
    //                 $news['created_at'] = $news['created_at']->toDateTime()->format('Y-m-d H:i:s');
    //             } else {
    //                 $news['created_at'] = null; // Or set a default value
    //             }
    //             $count = DB::table('jarp_log')
    //                 ->where('product_id', $news['id'])
    //                 ->where('user_id',$user_id)
    //                 ->first();
    //                 if($count){
    //                     $news['read'] = true;
    //                 }else{
    //                     $news['read'] = false;
    //                 }


    //                 $count = DB::table('bookmarks')
    //                 ->where('product_id', $news['id'])
    //                 ->where('user_id',$user_id)
    //                 ->first();
    //                 if($count){
    //                     $news['bookmarks'] = true;
    //                 }else{
    //                     $news['bookmarks'] = false;
    //                 }

    //             if (isset($news['updated_at']) && $news['updated_at'] instanceof \MongoDB\BSON\UTCDateTime) {
    //                 $news['updated_at'] = $news['updated_at']->toDateTime()->format('Y-m-d H:i:s');
    //             } else {
    //                 $news['updated_at'] = null; // Or set a default value
    //             }
    //             unset($news['_id']);
    //         }
    //         return response()->json(['error'=>false,'data' => $news,'code'=>200]);
    //     }

    //     if ($request->has('language')) {
    //         $query->where('language', $request->language);
    //     }

    //     if ($request->has('location')) {
    //         $query->where('location', $request->location);
    //     }

    //     $limit = $request->input('limit', 20);

    //     if ($request->has('last_id')) {
    //         try {
    //             $lastId = new ObjectId($request->last_id);
    //             $query->where('_id', '>', $lastId);
    //         } catch (\Exception $e) {
    //             return response()->json(['error' => true, 'message' => 'Invalid last_id', 'code' => 400]);
    //         }
    //     }
    //     $news = $query->orderBy('_id')->limit($limit)->get()->map(function ($item) use ($user_id) {
    //         $item['id'] = (string) $item['_id'];
    //         if (isset($item['created_at']) && $item['created_at'] instanceof \MongoDB\BSON\UTCDateTime) {
    //             $item['created_at'] = $item['created_at']->toDateTime()->format('Y-m-d H:i:s');
    //         } else {
    //             $item['created_at'] = null; // Or set a default value
    //         }

    //         $count = DB::table('jarp_log')
    //         ->where('product_id', $item['id'])
    //         ->where('user_id',$user_id)
    //         ->first();

    //         if($count){
    //             $item['read'] = true;
    //         }else{
    //             $item['read'] = false;
    //         }

    //         $count = DB::table('bookmarks')
    //         ->where('product_id', $item['id'])
    //         ->where('user_id',$user_id)
    //         ->first();
    //         if($count){
    //             $item['bookmarks'] = true;
    //         }else{
    //             $item['bookmarks'] = false;
    //         }

    //         if (isset($item['updated_at']) && $item['updated_at'] instanceof \MongoDB\BSON\UTCDateTime) {
    //             $item['updated_at'] = $item['updated_at']->toDateTime()->format('Y-m-d H:i:s');
    //         } else {
    //             $item['updated_at'] = null; // Or set a default value
    //         }
    //         unset($item['_id']);
    //         return $item;
    //     });
    //     $lastItem = $news->last();
        
    //     $nextCursor = ($news->count() >= $limit && $lastItem && isset($lastItem['id']))
    //     ? (string) $lastItem['id']
    //     : null;
    //     return response()->json([
    //         'error' => false,
    //         'data' => $news,
    //         'next_cursor' => $nextCursor,
    //         'code' => 200
    //     ]);
        
    // }


    public function index(Request $request)
    {
    
        $user_id = $request->user_id;
        $limit = $request->input('limit', 20);
        $page = max(1, (int) $request->input('page', 1)); // Ensure page >= 1
    
        $mongo = DB::connection('mongodb')->collection('news');
        
        // ✅ Apply filters
        if ($request->filled('language')) {
            $mongo->where('language', $request->language);
        }
        if ($request->filled('location')) {
            $mongo->where('location', $request->location);
        }
        if ($request->filled('category')) {
            $mongo->where('category', $request->category);
        }
        if ($request->filled('referFrom')) {
            $mongo->where('refer_from', $request->referFrom);
        }

        if ($request->filled('Keyword')) {
            $keyword = $request->Keyword;
            $mongo->where(function ($query) use ($keyword) {
                $regex = new \MongoDB\BSON\Regex($keyword, 'i'); // case-insensitive
                $query->orWhere('title', 'regex', $regex)
                    ->orWhere('short_description', 'regex', $regex)
                    ->orWhere('details', 'regex', $regex)
                    ->orWhere('category', 'regex', $regex)
                    ->orWhere('location', 'regex', $regex)
                    ->orWhere('refer_from', 'regex', $regex)
                    ->orWhere('language', 'regex', $regex)
                    ->orWhere('added_by', 'regex', $regex)
                    ->orWhere('updated_by', 'regex', $regex);
            });

        }
        
        // 🔢 Count before pagination
        $totalCount = $mongo->count();
    
        // 📄 Pagination
        $skip = ($page - 1) * $limit;
    
        // ⬇️ Fetch news list with pagination & sorting
        $newsList = $mongo->orderBy('_id', 'desc')->skip($skip)->limit($limit)->get();
    
        // 🔗 Join with SQL tables (bookmarks & read)
        $newsIds = $newsList->map(fn($item) => (string) $item['_id'])->all();
    
        $readProducts = DB::table('jarp_log')
            ->where('user_id', $user_id)
            ->whereIn('product_id', $newsIds)
            ->pluck('product_id')
            ->toArray();
    
        $bookmarkedProducts = DB::table('bookmarks')
            ->where('user_id', $user_id)
            ->whereIn('product_id', $newsIds)
            ->pluck('product_id')
            ->toArray();
    
        // 🛠 Format and enrich results
        $newsData = $newsList->map(function ($item) use ($readProducts, $bookmarkedProducts) {
            $item['id'] = (string) $item['_id'];
            $item['created_at'] = $this->formatDate($item['created_at'] ?? null);
            $item['updated_at'] = $this->formatDate($item['updated_at'] ?? null);
            $item['read'] = in_array($item['id'], $readProducts);
            $item['bookmarks'] = in_array($item['id'], $bookmarkedProducts);
            unset($item['_id']);
            return $item;
        });
    
        $totalPages = ceil($totalCount / $limit);
    
        return response()->json([
            'error' => false,
            'data' => $newsData,
            'total_count' => $totalCount,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'code' => 200
        ]);
    }
    


/**
 * Helper function to format MongoDB UTCDateTime to string or return null
 */
private function formatDate($date)
{
    if ($date instanceof \MongoDB\BSON\UTCDateTime) {
        return $date->toDateTime()->format('Y-m-d H:i:s');
    }
    return null;
}


public function create(Request $request)
{   
    return view('news.create');  // resources/views/news/create.blade.php
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'language' => 'required|string|max:10',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'referFrom' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'favourite' => 'required|in:yes,no',
            'details' => 'nullable|string',
            'shortDescription' => 'nullable|string',
        ]);
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $validated['image'] = $path;
        }
    
        // Add timestamps manually
        $validated['created_at'] = now();
        $validated['updated_at'] = now();
    
        // Insert using DB::table
        $id = DB::table('news')->insertGetId($validated);
    
        return redirect()->route('news.index')->with('success', 'News add successfully!');
    }

    public function destroy($id)
    {

        $news = DB::table('news')->where('_id', $id)->delete(); // ❌
        
        // if (!$news) {
        //     return response()->json(['message' => 'News not found'], 404);
        // }
    
        // $news->delete();
    
        return response()->json(['message' => 'News deleted successfully']);
    }
    
    public function edit($id)
    {
        $news = (object) DB::table('news')->find($id);
        if (!$news) {
            abort(404);
        }

        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateNews($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news_images', 'public');
        }

        $validated['updated_at'] = now();

        DB::table('news')->where('_id', $id)->update($validated);

        return redirect('news')->with('success', 'News updated successfully.');
    }


    protected function validateNews(Request $request)
    {
        return $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'language' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'referFrom' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'favourite' => 'required|in:yes,no',
            'details' => 'nullable|string',
            'shortDescription' => 'nullable|string',
        ]);
    }

    public function show($id)
    {
        $news = (object) DB::table('news')->find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $news->_id,
                'title' => $news->title ?? '',
                'category' => $news->category ?? '',
                'description' => $news->shortDescription ?? '',
                'image' => isset($item['image']) 
                ? "https://laravel1-kcmv.onrender.com/storage/app/public/" . $item['image'] : '',
                    'short_description' => $item['short_description'] ?? '',
                 'date' => $news->date ?? null,
                'time' => $news->time ?? null,
                'tag' => $news->tag ?? '',
                'location' => $news->location ?? '',
                'language' => $news->language ?? '',
                'refer_from' => $news->referFrom ?? '',
                'url' => $news->link ?? '',
                'favourite' => $news->favourite ?? false,
                'details' => $news->details ?? false,
            ]
        ]);
    }

    public function index1(Request $request)
    {
        $user_id = $request->user_id;
        $limit = (int) $request->input('limit', 20);
        $lastId = $request->input('cursor'); // cursor is the last _id from previous page
    
        $mongo = DB::connection('mongodb')->collection('news');
    
        // ✅ Apply filters
        if ($request->filled('language')) {
            $mongo->where('language', $request->language);
        }
        if ($request->filled('location')) {
            $mongo->where('location', $request->location);
        }
        if ($request->filled('category')) {
            $mongo->where('category', $request->category);
        }
        if ($request->filled('referFrom')) {
            $mongo->where('refer_from', $request->referFrom);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $mongo->where(function ($query) use ($keyword) {
                $regex = new \MongoDB\BSON\Regex($keyword, 'i'); // case-insensitive
                $query->orWhere('title', 'regex', $regex)
                    ->orWhere('short_description', 'regex', $regex)
                    ->orWhere('details', 'regex', $regex)
                    ->orWhere('category', 'regex', $regex)
                    ->orWhere('location', 'regex', $regex)
                    ->orWhere('refer_from', 'regex', $regex)
                    ->orWhere('language', 'regex', $regex)
                    ->orWhere('added_by', 'regex', $regex)
                    ->orWhere('updated_by', 'regex', $regex);
            });
            
        }
    
        // ▶️ Apply cursor if present
        if ($lastId) {
            $mongo->where('_id', '<', new \MongoDB\BSON\ObjectId($lastId));
        }
    
        // 📥 Fetch results sorted by newest first
        $newsList = $mongo->orderBy('_id', 'desc')->limit($limit)->get();
        $newsIds = $newsList->map(fn($item) => (string) $item['_id'])->all();
    
        $readProducts = DB::table('jarp_log')
            ->where('user_id', $user_id)
            ->whereIn('product_id', $newsIds)
            ->pluck('product_id')
            ->toArray();
    
        $bookmarkedProducts = DB::table('bookmarks')
            ->where('user_id', $user_id)
            ->whereIn('product_id', $newsIds)
            ->pluck('product_id')
            ->toArray();
    
        // 🔁 Format data
        $newsData = $newsList->map(function ($item) use ($readProducts, $bookmarkedProducts) {
            $id = (string) $item['_id'];
    
            return [
                'category'       => $item['category'] ?? '',
                'title'          => $item['title'] ?? '',
                'image' => isset($item['image']) 
                ? "https://laravel1-kcmv.onrender.com/storage/app/public/" . $item['image'] : '',
                    'short_description' => $item['short_description'] ?? '',
                'details'        => $item['details'] ?? '',
                'language'       => $item['language'] ?? '',
                'location'       => $item['location'] ?? '',
                'created_at'     => $this->formatDate($item['created_at'] ?? null),
                'tag'            => $item['tag'] ?? '',
                'id'             => $id,
                'read'           => in_array($id, $readProducts),
                'bookmark'       => in_array($id, $bookmarkedProducts),
                'metadata'       => [
                    'author'    => $item['added_by'] ?? '',
                    'source'    => $item['refer_from'] ?? '',
                    'sourceURL' => $item['link'] ?? '',
                ],
            ];
        });
    
        // ⏭️ Get next cursor
        $nextCursor = null;
        if (!$newsList->isEmpty()) {
            $nextCursor = (string) $newsList->last()['_id'];
        }
    
        return response()->json([
            'error' => false,
            'data' => $newsData,
            'next_cursor' => $nextCursor,
            'code' => 200,
        ]);
    }
    


public function apinewsStore(Request $request)
{
    $validator = Validator::make($request->all(), [
        'category' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'tag' => 'required|string|max:255',
        'language' => 'required|string|max:10',
        'location' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'date' => 'nullable|date',
        'time' => 'nullable',
        'refer_from' => 'nullable|string|max:255',
        'link' => 'nullable|url|max:255',
        'favourite' => 'required|in:yes,no',
        'details' => 'nullable|string',
        'shortDescription' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => true,
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422);
    }

    $validated = $validator->validated();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('news_images', 'public');
        $validated['image'] = Storage::url($path);
    }

    $validated['created_at'] = now();
    $validated['updated_at'] = now();

    $id = DB::table('news')->insertGetId($validated);

    return response()->json([
        'error' => false,
        'message' => 'News added successfully.',
        'news_id' => $id,
        'data' => $validated
    ], 201);
}


public function apinewsUpdate(Request $request, $id)
{
    // Validate input
    $validator = Validator::make($request->all(), [
        'category' => 'sometimes|required|string|max:255',
        'title' => 'sometimes|required|string|max:255',
        'tag' => 'sometimes|required|string|max:255',
        'language' => 'sometimes|required|string|max:10',
        'location' => 'sometimes|required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'date' => 'nullable|date',
        'time' => 'nullable',
        'referFrom' => 'nullable|string|max:255',
        'link' => 'nullable|url|max:255',
        'favourite' => 'sometimes|required|in:yes,no',
        'details' => 'nullable|string',
        'shortDescription' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => true,
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422);
    }

    $validated = $validator->validated();
    // Handle image upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('news_images', 'public');
        $validated['image'] = Storage::url($path);
    }

    $validated['updated_at'] = now();

    // Update record

    $updated = DB::connection('mongodb')
    ->collection('news')
    ->where('_id', new ObjectId($id))
    ->update($validated);
    
    if ($updated == 1) {
        return response()->json([
            'error' => false,
            'message' => 'News updated successfully.',
            'news_id' => $id,
            'data' => $validated
        ]);
    } else {
        return response()->json([
            'error' => true,
            'message' => 'News not found or nothing to update.'
        ], 404);
    }
}


}
