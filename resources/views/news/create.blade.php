@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="css/style.css">

<main style="flex: 1; padding: 0; overflow-y: auto; background-color: #f5f6fa;">
  <div style="background: white; padding: 30px; width: 100%; height: 100%;">
    <h2 style="margin-top: 0; color: #333;">Create News</h2>

    <!-- Show validation errors -->
    @if ($errors->any())
      <div style="color: red; margin-bottom: 20px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- Success message -->
    @if (session('success'))
      <div style="color: green; margin-bottom: 20px;">
        {{ session('success') }}
      </div>
    @endif

    <form style="display: flex; flex-wrap: wrap; gap: 20px;" enctype="multipart/form-data" method="POST" action="{{ route('news.store') }}">
      @csrf

      <div style="flex: 1 1 30%;">
        <label for="category">Category</label>
        <input type="text" id="category" name="category" class="form-control" >
      </div>

      <div style="flex: 1 1 30%;">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control" >
      </div>

      <div style="flex: 1 1 30%;">
        <label for="tag">Tag</label>
        <input type="text" id="tag" name="tag" class="form-control" >
      </div>


      <div style="flex: 1 1 30%;">
        <label for="language">Language</label>
        <select id="language" name="language" class="form-control">
          <option value="en" {{ old('language', 'English') == 'en' ? 'selected' : '' }}>English</option>
          <option value="hi" {{ old('language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
          <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>French</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="location">Location</label>
        <select id="location" name="location" class="form-control">
          <option value="delhi" {{ old('location', 'delhi') == 'delhi' ? 'selected' : '' }}>Delhi</option>
          <option value="mumbai" {{ old('location') == 'mumbai' ? 'selected' : '' }}>Mumbai</option>
          <option value="bangalore" {{ old('location') == 'bangalore' ? 'selected' : '' }}>Bangalore</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept="image/*" class="form-control">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" class="form-control" value="{{ old('date', now()->format('Y-m-d')) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="time">Time</label>
        <input type="time" id="time" name="time" class="form-control" value="{{ old('time', now()->format('H:i')) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="referFrom">Refer From</label>
        <input type="text" id="refer_from" name="refer_from" class="form-control" >
      </div>

      <div style="flex: 1 1 30%;">
        <label for="link">Link</label>
        <input type="url" id="link" name="link" class="form-control" >
      </div>

      <div style="flex: 1 1 48%;">
        <label for="favourite">Favourite</label>
        <select id="favourite" name="favourite" class="form-control">
          <option value="yes" {{ old('favourite', 'yes') == 'yes' ? 'selected' : '' }}>Yes</option>
          <option value="no" {{ old('favourite') == 'no' ? 'selected' : '' }}>No</option>
        </select>
      </div>

      <div style="flex: 1 1 48%;">
        <label for="details">Details</label>
        <textarea id="details" name="details" class="form-control" style="height: 40px; resize: none;"></textarea>
      </div>

      <div style="flex: 1 1 100%;">
        <label for="shortDescription">Short Description</label>
        <textarea id="shortDescription" name="shortDescription" rows="3" class="form-control"></textarea>
      </div>

      <div style="flex: 1 1 100%; text-align: right; margin-top: 20px;">
        <button type="submit" style="
          padding: 10px 25px;
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
        ">Create News</button>
      </div>
    </form>
  </div>
</main>
@endsection
