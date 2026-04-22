  </div><!-- /.pld-content -->
</div><!-- /.pld-main -->
</div><!-- /.pld-wrapper -->

<!-- Scripts -->
<script src="/workwave/View/assets/plot-listing/vendor/jquery/jquery.min.js"></script>
<script src="/workwave/View/assets/plot-listing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
// Mobile sidebar toggle
(function() {
  const burger  = document.getElementById('pldBurger');
  const sidebar = document.getElementById('pldSidebar');
  if (!burger || !sidebar) return;
  burger.addEventListener('click', function() {
    sidebar.classList.toggle('open');
  });
  // Close on outside click
  document.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !burger.contains(e.target)) {
      sidebar.classList.remove('open');
    }
  });
})();
</script>

</body>
</html>
