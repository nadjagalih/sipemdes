(function(){
  const sidebar = document.getElementById('sidebar');
  const toggle  = document.getElementById('sidebarToggle');
  if (toggle && sidebar) {
    toggle.addEventListener('click', function(){
      sidebar.classList.toggle('show');
    });
  }

  // If the original sidebar contains collapse menus using legacy classes,
  // you can hook them here to Bootstrap's collapse if needed.
})();