@extends('layouts.app')

@section('content')

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
      color: #dc3545; /* Bootstrap's danger color */
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="row g-0">
      <div class="col-md-5">
        <img
          src="https://via.placeholder.com/600x400"
          alt="Sample News Title 5001"
          class="news-image"
        />
      </div>
      <div class="col-md-7">
        <div class="card-body">
          <h1 class="card-title mb-3">Sample News Title 5001
            <span
              class="favourite-badge"
              title="Favourite"
              aria-label="Favourite">&#10084;</span>
          </h1>
          <p class="text-muted mb-1">
            <strong>Category:</strong> tq0eQQj7cP
          </p>
          <p class="text-muted mb-1">
            <strong>Date:</strong> 2025-05-06
          </p>
          <p class="text-muted mb-3">
            <strong>Time:</strong> 17:07:06
          </p>
          <p class="card-text fst-italic">
            mkuTAi7j87vPja7Em3js7KXdFoKWBGbWUX0dm2dghspLvt5cZI
          </p>
          <hr />
          <p>
            GJEEDuVjNjtPHyJyy2OdCCZ9Z2ExWWcnHn0zHyTqYgrdH8Uvr9j30UNuETWhf3GYcq1dsEBMEr7l8UvB48tFQSGmHtE6V6e8sfMBzxxpnSwo0SIe4Xy3fq6PqpWGEJ0YV1EKZxlv6iR9nITf5QJCOBegLYH3oZeYfovxlPUe8khzgnDMtmLkXHimS4A84JlL5hvJC1L6
          </p>
          <hr />
          <p><strong>Language:</strong> English</p>
          <p><strong>Location:</strong> Kolkata</p>
          <p><strong>Reference:</strong> Newsify</p>
          
          <a
            href="https://example.com/news/5001"
            target="_blank"
            rel="noopener noreferrer"
            class="btn btn-primary mt-3"
          >
            Read Full Article
          </a>
          <a href="javascript:history.back()" class="btn btn-outline-secondary mt-3 ms-2">Go Back</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS bundle (optional if you want interactive components) -->
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous"
></script>
@endsection
