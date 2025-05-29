@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  .loader {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    color: #333;
    z-index: 9999;
  }
  .pagination {
    margin-bottom: 40px;
    text-align: center;
  }
  .pagination button {
    padding: 6px 12px;
    margin: 0 4px;
    font-size: 16px;
    cursor: pointer;
  }
  .pagination button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  .filter-row {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
    flex-wrap: wrap;
  }
  .filter-row select, .filter-row input {
    padding: 5px;
    font-size: 14px;
  }
</style>

<!-- Loader -->
<div id="loader" class="loader">
  <i class="fas fa-spinner fa-spin"></i> Loading...
</div>

<div class="main">
  @if(session('success'))
    <div style="color: green; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
  @endif

  <div class="main-header">
    <h2>News Table</h2>
    <a href="{{ url('news-create') }}" class="btn btn-primary d-inline-flex align-items-center">
  <i class="fas fa-newspaper me-2"></i> Create News
</a>

  </div>

  <!-- Filters -->
  <div class="filter-row">
    <div class="row-2">
    <input type="text" class="form-control"  id="filter-category" placeholder="Category">
</div>
<div class="row-2">

    <input type="text" class="form-control"  id="filter-referFrom" placeholder="Refer From">
    </div>

    <div class="row-2">

    <select class="form-control"  id="filter-location">
      <option value="">All Locations</option>
      <option value="delhi">Delhi</option>
      <option value="mumbai">Mumbai</option>
      <option value="bangalore">Bangalore</option>
    </select>
    </div>

    <div class="row-2">

    <select class="form-control"  id="filter-language">
      <option value="">All Languages</option>
      <option value="en">English</option>
      <option value="hi">Hindi</option>
      <option value="fr">French</option>
    </select>
    </div>

    <button onclick="applyFilters()" class="btn btn-primary me-2">Filter</button>
    <button onclick="clearFilters()" class="btn btn-outline-secondary">Clear</button>
    </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Category</th>
          <th>Title</th>
          <th>Image</th>
          <th>Refer From</th>
          <th>Language</th>
          <th>Location</th>
          <th>Link</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="news-body"></tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="pagination">
    <button id="prev-btn" onclick="goToPreviousPage()" disabled>Previous</button>
    <span id="page-info">Page 1 of 1</span>
    <button id="next-btn" onclick="goToNextPage()" disabled>Next</button>
  </div>
</div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  let currentPage = 1;
  let totalPages = 1;
  const limit = 20;

  function getFilters() {
    return {
      category: document.getElementById('filter-category').value.trim(),
      location: document.getElementById('filter-location').value,
      language: document.getElementById('filter-language').value,
      referFrom: document.getElementById('filter-referFrom').value.trim(),
    };
  }

  function buildQueryParams(page = 1) {
    const filters = getFilters();
    let params = `?limit=${limit}&page=${page}`;

    Object.entries(filters).forEach(([key, value]) => {
      if (value) {
        params += `&${key}=${encodeURIComponent(value)}`;
      }
    });

    return params;
  }

  async function fetchNews(page = 1) {
    const loader = document.getElementById('loader');
    loader.style.display = 'block';

    try {
      const url = `${API_BASE_URL}/news-list${buildQueryParams(page)}`;
      const response = await fetch(url);
      if (!response.ok) throw new Error("Server error");

      const result = await response.json();
      const data = result.data;
      totalPages = result.total_pages || 1;

      const tbody = document.getElementById('news-body');
      tbody.innerHTML = '';

      if (!Array.isArray(data) || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9">No news available</td></tr>';
        document.getElementById('next-btn').disabled = true;
        document.getElementById('prev-btn').disabled = true;
        document.getElementById('page-info').textContent = '';
        return;
      }

      let ct = (page - 1) * limit + 1;

      data.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${ct}</td>
          <td>${item.category || ''}</td>
          <td>${item.title || ''}</td>
          <td>${item.image ? `<img src="public/news_images${item.image}" alt="news image" width="100">` : ''}</td>
          <td>${item.refer_from || ''}</td>
          <td>${item.language || ''}</td>
          <td>${item.location || ''}</td>
          <td><a href="${item.url || '#'}" target="_blank">Link</a></td>
          <td>
            <div class="action-buttons">
              <a href="news-details/${item.id}" class="btn view">View</a>
              <a href="news/${item.id}/edit" class="btn edit">Edit</a>
              <button class="btn delete" data-id="${item.id}">Delete</button>
            </div>
          </td>
        `;
        tbody.appendChild(row);
        ct++;
      });

      currentPage = page;
      document.getElementById('prev-btn').disabled = (currentPage <= 1);
      document.getElementById('next-btn').disabled = (currentPage >= totalPages);
      document.getElementById('page-info').textContent = `Page ${currentPage} of ${totalPages}`;

    } catch (error) {
      alert("Failed to fetch news.");
      console.error(error);
    } finally {
      loader.style.display = 'none';
    }
  }

  function goToNextPage() {
    if (currentPage < totalPages) {
      fetchNews(currentPage + 1);
    }
  }

  function goToPreviousPage() {
    if (currentPage > 1) {
      fetchNews(currentPage - 1);
    }
  }

  function applyFilters() {
    fetchNews(1);
  }

  function clearFilters() {
    document.getElementById('filter-category').value = '';
    document.getElementById('filter-location').value = '';
    document.getElementById('filter-language').value = '';
    document.getElementById('filter-referFrom').value = '';
    fetchNews(1);
  }

  // Delete handler
  document.addEventListener('click', async function (e) {
    if (e.target.classList.contains('delete')) {
      const id = e.target.getAttribute('data-id');

      if (confirm('Are you sure you want to delete this news item?')) {
        try {
          const response = await fetch(`${API_BASE_URL}/news-delete/${id}`, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
            }
          });

          if (!response.ok) throw new Error('Delete failed');

          alert('News deleted successfully');
          fetchNews(currentPage);
        } catch (error) {
          alert('Failed to delete news');
          console.error(error);
        }
      }
    }
  });

  // Load initial news list
  fetchNews(currentPage);
</script>

<script src="js/script.js"></script>
@endsection
