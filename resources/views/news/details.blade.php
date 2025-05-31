@extends('layouts.app')

@section('content')
<head>
</head>
<style>
  body {
    background: #f8f9fa;
  }
  .news-image {
    max-height: 400px;
    object-fit: cover;
    width: 100%;
    border-radius: 8px;
  }
  .favourite-badge {
    font-size: 1.2rem;
    color: #dc3545;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container py-5">
  <div id="loader" class="text-center my-4" style="display: none;">
    <i class="fas fa-spinner fa-spin fa-2x"></i> Loading...
  </div>

  <div id="news-card" class="card shadow-sm" style="display: none;">
    <div class="row g-0">
      <div class="col-md-5">
        <img id="news-image" class="news-image" />
      </div>
      <div class="col-md-7">
        <div class="card-body">
          <h1 id="news-title" class="card-title mb-3">
            <span class="favourite-badge" title="Favourite" aria-label="Favourite">&#10084;</span>
          </h1>
          <p class="text-muted mb-1"><strong>Category:</strong> <span id="news-category"></span></p>
          <p class="text-muted mb-1"><strong>Date:</strong> <span id="news-date"></span></p>
          <p class="text-muted mb-3"><strong>Time:</strong> <span id="news-time"></span></p>
          <p class="card-text fst-italic" id="news-tag"></p>
          <hr />
          <p id="news-description"></p>
          <hr />
          <p><strong>Language:</strong> <span id="news-language"></span></p>
          <p><strong>Location:</strong> <span id="news-location"></span></p>
          <p><strong>Reference:</strong> <span id="news-refer-from"></span></p>

          <a id="news-url" target="_blank" rel="noopener noreferrer" class="btn btn-primary mt-3">Read Full Article</a>
          <a href="javascript:history.back()" class="btn btn-outline-secondary mt-3 ms-2">Go Back</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";

  document.addEventListener("DOMContentLoaded", async function () {
    const pathParts = window.location.pathname.split('/');
    const newsId = pathParts[pathParts.length - 1];

    const loader = document.getElementById('loader');
    const newsCard = document.getElementById('news-card');
    loader.style.display = 'block';

    try {
      const res = await fetch(`${API_BASE_URL}/news-details/${newsId}`);
      if (!res.ok) throw new Error("Failed to load news");

      const result = await res.json();
      const item = result.data;

      document.getElementById('news-title').prepend(item.title || 'No Title');
      document.getElementById('news-category').textContent = item.category || '';
      document.getElementById('news-date').textContent = item.date || '';
      document.getElementById('news-time').textContent = item.time || '';
      document.getElementById('news-tag').textContent = item.tag || '';
      document.getElementById('news-description').textContent = item.description || '';
      document.getElementById('news-language').textContent = item.language || '';
      document.getElementById('news-location').textContent = item.location || '';
      document.getElementById('news-refer-from').textContent = item.refer_from || '';
      document.getElementById('news-url').href = item.url || '#';

      const imageUrl = item.image
        ? `{{ asset('storage/news_images') }}/${item.image}`
        : 'https://via.placeholder.com/600x400';
      document.getElementById('news-image').src = imageUrl;

      newsCard.style.display = 'block';
    } catch (err) {
      alert('Could not load news details.');
      console.error(err);
    } finally {
      loader.style.display = 'none';
    }
  });
</script>
@endsection
