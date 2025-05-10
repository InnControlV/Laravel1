<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Movie;
use App\Models\ShoppingItem;
use DB;
class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalNews = DB::table('news')->count();
        $totalMovies = DB::table('movies')->count();
        $totalShoppingItems = DB::table('shopping_items')->count();

        // Get the last 5 entries for each category
        $latestNews = DB::table('news')->orderBy('created_at', 'desc')->take(5)->get();
        $latestMovies = DB::table('movies')->orderBy('created_at', 'desc')->take(5)->get();
        $latestShoppingItems = DB::table('shopping')->orderBy('created_at', 'desc')->take(5)->get();

        // Pass the data to the view
        return view('layouts.dashboard', compact(
            'totalNews', 
            'totalMovies', 
            'totalShoppingItems', 
            'latestNews', 
            'latestMovies', 
            'latestShoppingItems'
        ));
    }
}
