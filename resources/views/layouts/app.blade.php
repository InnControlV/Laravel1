<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'JARP')</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      overflow-x: hidden;
    }

    .navbar {
      background-color: black;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }

    .wrapper {
      display: flex;
      padding-top: 56px; /* Height of the fixed header */
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      background-color: black;
      color: white;
      overflow-y: auto;
      transition: all 0.3s ease;
      position: fixed;
      top: 56px;
      left: 0;
      z-index: 999;
    }

    .sidebar.collapsed {
      width: 0;
      overflow: hidden;
    }

    .content {
      margin-left: 220px;
      padding: 20px;
      transition: margin-left 0.3s ease;
      width: 100%;
    }

    .content.full-width {
      margin-left: 40px;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
      color: white;
    }

    .nav-link,
    .toggle-btn {
      color: white !important;
    }

    .btn-primary {
      background: linear-gradient(135deg, #007bff, #ff69b4);
      border: none;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #0056b3, #e83e8c);
    }

    /* Responsive sidebar collapse */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.collapsed {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  @include('partials.header')

  <div class="wrapper">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="content" id="main-content">
      @yield('content')
    </div>
  </div>

  @include('partials.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar Toggle Script -->
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('main-content');

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('full-width');
      });
    }
  </script>
</body>
</html>
<script src="../js/script.js"></script>
