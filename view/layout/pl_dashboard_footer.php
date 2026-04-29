    </div><!-- /.container -->

    <!-- Footer -->
    <footer>
        <div class="footer-content" style="text-align: center; padding: 30px; background: rgba(26, 29, 41, 0.8); border-top: 1px solid rgba(0, 255, 204, 0.1); margin-top: 40px;">
            <p class="copyright" style="color: #a0a0a0; font-size: 14px;">© 2026 WorkWave. Tous droits réservés. Connecter les talents aux opportunités. 
            | Designed by <a href="https://templatemo.com" rel="nofollow noopener" target="_blank" style="color: #00ffcc; text-decoration: none;">TemplateMo</a></p>
        </div>
    </footer>

    <!-- Graph Page Scripts -->
    <script src="/workwave/View/assets/template_user/templatemo-graph-script.js"></script>

    <!-- Custom Script for Navbar active states and mobile menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const navLinksMobile = document.getElementById('navLinksMobile');

            if (hamburger && navLinksMobile) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    navLinksMobile.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
