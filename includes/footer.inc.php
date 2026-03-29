<footer class="mt-5 py-4">
  <div class="container text-center">
    <span style="font-family:'Bebas Neue',sans-serif;font-size:1.3rem;letter-spacing:2px;color:var(--accent)">MOVE<span style="color:var(--accent2)">MOVIE</span></span>
    <p class="text-muted-mm mt-1 mb-0" style="font-size:.8rem">Movie reviews by the community &copy; <?php echo date('Y'); ?></p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ============================================================
//  THEME TOGGLE
// ============================================================
(function () {
  const btn   = document.getElementById('themeToggle');
  const icon  = document.getElementById('themeIcon');
  const label = document.getElementById('themeLabel');

  function applyTheme(mode) {
    if (mode === 'light') {
      document.documentElement.classList.add('light-mode');
      document.body.classList.add('light-mode');
      icon.className    = 'bi bi-moon-fill';
      label.textContent = 'Dark';
    } else {
      document.documentElement.classList.remove('light-mode');
      document.body.classList.remove('light-mode');
      icon.className    = 'bi bi-sun-fill';
      label.textContent = 'Light';
    }
    localStorage.setItem('mm_theme', mode);
  }

  // Sync icon with saved preference on every page load
  const saved = localStorage.getItem('mm_theme') || 'dark';
  applyTheme(saved);

  // Click handler
  btn.addEventListener('click', function () {
    const current = localStorage.getItem('mm_theme') || 'dark';
    applyTheme(current === 'dark' ? 'light' : 'dark');
  });
})();

// ============================================================
//  SWEETALERT2 — respects current theme
// ============================================================
$(document).on('click', '.confirm-delete', function (e) {
  e.preventDefault();
  const href   = $(this).attr('href');
  const msg    = $(this).data('msg') || "You won't be able to revert this!";
  const isLight = document.body.classList.contains('light-mode');
  Swal.fire({
    title: 'Are you sure?', text: msg, icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e05c5c',
    cancelButtonColor: isLight ? '#888' : '#2a2a3e',
    confirmButtonText: 'Yes, delete it!',
    background: isLight ? '#ffffff' : '#1a1a26',
    color:      isLight ? '#1a1a2e' : '#e8e8f0',
  }).then(r => { if (r.isConfirmed) window.location.href = href; });
});

// ============================================================
//  SHOW / HIDE PASSWORD
// ============================================================
$(document).on('change', '.show-password-toggle', function () {
  const target = $($(this).data('target'));
  target.attr('type', this.checked ? 'text' : 'password');
});
</script>
</body>
</html>