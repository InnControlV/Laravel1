@extends('layouts.app')

@section('content')

<main style="flex: 1; padding: 0; overflow-y: auto; background-color: #f5f6fa;">
  <div style="background: white; padding: 30px; width: 100%; height: 100%;">
    <h2 style="margin-top: 0; color: #333;">Edit News</h2>

    @if (session('success'))
      <div style="color: green; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    <form style="display: flex; flex-wrap: wrap; gap: 20px;" enctype="multipart/form-data" method="POST" action="{{ route('news.update', $news->_id) }}">
      @csrf

      <div style="flex: 1 1 30%;">
        <label for="category">Category</label>
        <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $news->category) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $news->title) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="language">Language</label>
        <select id="language" name="language" class="form-control">
          <option value="en" {{ old('language', $news->language) == 'en' ? 'selected' : '' }}>English</option>
          <option value="hi" {{ old('language', $news->language) == 'hi' ? 'selected' : '' }}>Hindi</option>
          <option value="fr" {{ old('language', $news->language) == 'fr' ? 'selected' : '' }}>French</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="location">Location</label>
        <select id="location" name="location" class="form-control">
          <option value="delhi" {{ old('location', $news->location) == 'delhi' ? 'selected' : '' }}>Delhi</option>
          <option value="mumbai" {{ old('location', $news->location) == 'mumbai' ? 'selected' : '' }}>Mumbai</option>
          <option value="bangalore" {{ old('location', $news->location) == 'bangalore' ? 'selected' : '' }}>Bangalore</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept="image/*" class="form-control">
        @if (!empty($news->image))
        <div style="margin-top: 10px;">
            <img src="{{ asset('storage/' . $news->image) }}" alt="Current Image" width="100">
          </div>
        @endif
      </div>

      <div style="flex: 1 1 30%;">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $news->date) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="time">Time</label>
        <input type="time" id="time" name="time" class="form-control" value="{{ old('time', $news->time) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="referFrom">Refer From</label>
        <input type="text" id="referFrom" name="referFrom" class="form-control" value="{{ old('referFrom', $news->referFrom) }}">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="link">Link</label>
        <input type="url" id="link" name="link" class="form-control" value="{{ old('link', $news->link) }}">
      </div>

      <div style="flex: 1 1 48%;">
        <label for="favourite">Favourite</label>
        <select id="favourite" name="favourite" class="form-control">
          <option value="yes" {{ old('favourite', $news->favourite) == 'yes' ? 'selected' : '' }}>Yes</option>
          <option value="no" {{ old('favourite', $news->favourite) == 'no' ? 'selected' : '' }}>No</option>
        </select>
      </div>

      <div style="flex: 1 1 48%;">
        <label for="details">Details</label>
        <textarea id="details" name="details" class="form-control" style="height: 40px; resize: none;">{{ old('details', $news->details) }}</textarea>
      </div>

      <div style="flex: 1 1 100%;">
        <label for="shortDescription">Short Description</label>
        <textarea id="shortDescription" name="shortDescription" rows="3" class="form-control">{{ old('shortDescription', $news->shortDescription) }}</textarea>
      </div>

      <div style="flex: 1 1 100%; text-align: right; margin-top: 20px;">
        <button type="submit" style="
          padding: 10px 25px;
          background-color: #28a745;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
        ">Update News</button>
      </div>
    </form>
  </div>
</main>
@endsection
