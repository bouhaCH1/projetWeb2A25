    <?php $isHome = empty($_GET['action']) || $_GET['action'] === 'home'; ?>
    <?php if (!$isHome): ?>
    </div> <!-- Close the .container that we opened in header.php for non-home views -->
    <?php endif; ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/workwave/index.php" class="logo">Work<span>Wave</span></a>
                    <p>Your trusted partner in career building and recruitment. We provide secure, transparent, and competitive job placement services worldwide.</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Services</h4>
                    <ul class="footer-links">
                        <li><a href="/workwave/index.php?action=register">Post a Job</a></li>
                        <li><a href="/workwave/index.php">Find a Job</a></li>
                        <li><a href="/workwave/index.php?action=login">Employer Login</a></li>
                        <li><a href="/workwave/index.php?action=login">Seeker Login</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Contact</h4>
                    <p style="color: #999;">Email: info@jobplatform.com</p>
                    <p style="color: #999;">Tel: 010-040-0220</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">&copy; 2026 WorkWave. All rights reserved. Design based on <a href="https://templatemo.com" target="_blank" style="color: var(--gold-light);">TemplateMo</a></p>
            </div>
        </div>
    </footer>

    <script src="/workwave/templatemo-aurum-script.js"></script>
</body>
</html>
