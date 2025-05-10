<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'JARP')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
   .navbar {
  background: linear-gradient(135deg, #007bff, #ff69b4);
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000; /* Ensure the header stays on top of other content */
}

.content {
  margin-top: 70px; /* Adjust the top margin to make space for the fixed header */
}

body {
  margin: 0;
  overflow-x: hidden;
}

.wrapper {
  display: flex;
}

/* Sidebar */
.sidebar {
  position: fixed; /* Fix the sidebar to the left */
  width: 220px;
  height: 100vh;
  overflow-y: auto;
  background: linear-gradient(180deg, #6f42c1, #f06292);
  color: white;
  transition: all 0.3s;
  z-index: 999; /* Keep the sidebar on top of the content */
}

.sidebar.collapsed {
  width: 0;
  overflow: hidden;
}

.content {
  flex-grow: 1;
  padding: 20px;
  margin-left: 220px; /* Add space for the sidebar */
  transition: margin-left 0.3s ease;
}

/* Navbar Branding and Links */
.navbar-brand {
  font-weight: bold;
  font-size: 1.4rem;
  color: white;
}

.nav-link {
  color: white !important;
}

.toggle-btn {
  border: none;
  background: none;
  color: white;
  font-size: 1.3rem;
}

.btn-primary {
  background: linear-gradient(135deg, #007bff, #ff69b4);
  border: none;
}

.btn-primary:hover {
  background: linear-gradient(135deg, #0056b3, #e83e8c);
}

/* Sidebar collapsing behavior for smaller screens */
@media (max-width: 768px) {
  .sidebar {
    position: fixed;
    z-index: 1000;
    height: 100%;
    transform: translateX(-100%); /* Hide sidebar on mobile */
  }

  .sidebar.collapsed {
    transform: translateX(0); /* Slide in the sidebar */
  }

  .content {
    margin-left: 0; /* Remove margin for mobile view */
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
    <div class="content">
      @yield('content')
    </div>
  </div>
    @include('partials.footer')

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
      document.getElementById('sidebar').classList.toggle('collapsed');
    });
  </script>
</body>
</html>
