@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<hr>

<div class="container">
<div class="row mb-4">
    <!-- Total News -->
    <div class="col-md-4">
        <div class="card mb-4" style="background: linear-gradient(135deg, #00c6ff, #0072ff);">
            <div class="card-body text-center text-white">
                <h4>Total News</h4>
                <p class="display-4">{{ $totalNews }}</p>
            </div>
        </div>
    </div>

    <!-- Total Movies -->
    <div class="col-md-4">
        <div class="card mb-4" style="background: linear-gradient(135deg, #ff7e5f, #feb47b);">
            <div class="card-body text-center text-white">
                <h4>Total Movies</h4>
                <p class="display-4">{{ $totalMovies }}</p>
            </div>
        </div>
    </div>

    <!-- Total Shopping Items -->
    <div class="col-md-4">
        <div class="card mb-4" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
            <div class="card-body text-center text-white">
                <h4>Total Shopping Items</h4>
                <p class="display-4">{{ $totalShoppingItems }}</p>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <!-- Latest News -->
    <div class="col-md-4">
        <div class="card mb-4 shadow-lg" style="border-radius: 10px; background: linear-gradient(135deg, #00c6ff, #0072ff);">
            <div class="card-header text-white" style="background: rgba(0, 0, 0, 0.5); border-radius: 10px 10px 0 0;">
                <h5 class="mb-0">Latest News</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($latestNews as $news)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="border: none; background-color: rgba(255, 255, 255, 0.7); border-radius: 5px; margin-bottom: 10px;">
                            {{ $news['title'] }}
                            <small class="text-muted">------</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Latest Movies -->
    <div class="col-md-4">
        <div class="card mb-4 shadow-lg" style="border-radius: 10px; background: linear-gradient(135deg, #ff7e5f, #feb47b);">
            <div class="card-header text-white" style="background: rgba(0, 0, 0, 0.5); border-radius: 10px 10px 0 0;">
                <h5 class="mb-0">Latest Movies</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($latestMovies as $movie)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="border: none; background-color: rgba(255, 255, 255, 0.7); border-radius: 5px; margin-bottom: 10px;">
                            {{ $movie['title'] }}
                            <small class="text-muted">-----</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Latest Shopping Items -->
    <div class="col-md-4">
        <div class="card mb-4 shadow-lg" style="border-radius: 10px; background: linear-gradient(135deg, #6a11cb, #2575fc);">
            <div class="card-header text-white" style="background: rgba(0, 0, 0, 0.5); border-radius: 10px 10px 0 0;">
                <h5 class="mb-0">Latest Shopping Items</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($latestShoppingItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="border: none; background-color: rgba(255, 255, 255, 0.7); border-radius: 5px; margin-bottom: 10px;">
                            {{ $item['name'] }}
                            <small class="text-muted">------</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
