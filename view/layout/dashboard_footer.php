    </div><!-- /.dsh-content -->
</div><!-- /.dsh-main -->
</div><!-- /.dsh-wrapper -->

<script>
(function () {
    var sidebar = document.getElementById('dshSidebar');
    var burger  = document.getElementById('dshBurger');
    if (!sidebar || !burger) return;
    burger.addEventListener('click', function () {
        sidebar.classList.toggle('open');
    });
    document.addEventListener('click', function (e) {
        if (!sidebar.contains(e.target) && !burger.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
}());
</script>
</body>
</html>
