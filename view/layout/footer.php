    <?php $isHome = empty($_GET['action']) || $_GET['action'] === 'home'; ?>
    <?php if (!$isHome): ?>
    </div> <!-- Close the .container that we opened in header.php for non-home views -->
    <?php endif; ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="/workwave/Controller/index.php" class="logo">Work<span>Wave</span></a>
                    <p>Your trusted partner in career building and recruitment. We provide secure, transparent, and competitive job placement services worldwide.</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Core Features</h4>
                    <ul class="footer-links">
                        <li><a href="/workwave/Controller/index.php?action=register">💼 Post Job Listings</a></li>
                        <li><a href="/workwave/Controller/index.php?action=register">🔍 Find Top Candidates</a></li>
                        <li><a href="/workwave/Controller/index.php?action=register">📄 Create Professional Profile</a></li>
                        <li><a href="/workwave/Controller/index.php?action=register">🚀 Secure Fast Placements</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Contact</h4>
                    <p style="color: #999;">Email: contact@workwave.com</p>
                    <p style="color: #999;">Tel: 010-040-0220</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">&copy; 2026 WorkWave. All rights reserved. Design based on <a href="https://templatemo.com" target="_blank" style="color: var(--gold-light);">TemplateMo</a></p>
                <p class="footer-copy" style="margin-top:8px;"><a href="/workwave/Controller/index.php?action=admin_login" style="color:#666;font-size:0.85rem;">Administrator login</a></p>
            </div>
        </div>
    </footer>

    <script src="/workwave/View/assets/templatemo-aurum-script.js"></script>
</body>
</html>
