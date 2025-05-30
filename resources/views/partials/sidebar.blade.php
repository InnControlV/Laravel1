
<div class="sidebar" id="sidebar">
  <ul>
    <li>
      <a href="index.html"><i class="fas fa-home"></i><span>Dashboard</span></a>
      
    </li>
      <li>
      <a href="#"><i class="fas fa-user"></i><span> Profile</span>

      
    </li>

    <!-- Profile Section -->
    <li class="has-submenu" onclick="toggleSubmenu('profile-submenu')">
      <i class="fas fa-newspaper"></i><span>News <i class="fa fa-angle-double-down"></i></span>
    </li>
    <ul class="submenu" id="profile-submenu">
      <li> <i class="fa-solid fa-list"></i><a href="{{ url('news' )}}">list-news</a></li>
      <li><i class="fa-solid fa-plus"></i><a href="{{url('news-create') }}">Create News</a></li>
    </ul>

    <!-- Settings Section -->
    <li class="has-submenu" onclick="toggleSubmenu('settings-submenu')">
      <i class="fas fa-film"></i><span>Movies<i class="fa fa-angle-double-down"></i></span>
    </li>
    <ul class="submenu" id="settings-submenu">
      <li><i class="fa-solid fa-list"></i><a href="List-movie.html">List Movie</a></li>
      <li><i class="fa-solid fa-plus"></i><a href="Create-Movie.html">Create Movie</a></li>
      <li><i class="fa-solid fa-expand"></i><a href="View-movie.html">View movie</a></li>
    </ul>
      <li>
      <a href="Shopping.html"><i class="fa-solid fa-cart-shopping"></i><span>Shopping</span></a>
      
    </li>
  
      <li>
      <a href="Read.html"><i class="fa-solid fa-book-open"></i><span>Read</span></a>
      
    </li>
      <li>
      <a href="Bookmarks.html"><i class="fa-solid fa-book-bookmark"></i><span>Bookmarks</span></a>
      
    </li>
      <li>
      <a href="#"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
      
    </li>

    <li>
      <a href="#"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </li>
  </ul>
</div>
<script>


</script>