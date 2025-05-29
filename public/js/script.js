

// Attach toggle function after header loads
function attachToggleEvent() {
  window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('toggle-icon');

    if (sidebar.classList.contains('collapsed')) {
      sidebar.classList.remove('collapsed');
      icon.classList.remove('fa-bars');
      icon.classList.add('fa-xmark'); // close icon
    } else {
      sidebar.classList.add('collapsed');
      icon.classList.remove('fa-xmark');
      icon.classList.add('fa-bars'); // hamburger icon
    }
  };

  window.logout = function () {
    alert("Logging out...");
    // Add actual logout logic
  };
}
function toggleSubmenu(id) {
  const submenu = document.getElementById(id);
  submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
}
