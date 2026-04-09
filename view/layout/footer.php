            </div> <!-- end templatemo_content -->

            <div id="templatemo_sidebar">
                <div class="sidebar_box">
                    <h2>Quick Links</h2>
                    <ul class="tmo_list">
                        <?php if (!empty($_SESSION['user_id'])): ?>
                            <li><a href="/job_platform/index.php?action=profile">My Profile</a></li>
                            <?php if ($_SESSION['user_role'] === 'employer'): ?>
                            <li><a href="/job_platform/index.php?action=admin_users">Manage Users</a></li>
                            <?php endif; ?>
                            <li><a href="/job_platform/index.php?action=logout">Log Out</a></li>
                        <?php else: ?>
                            <li><a href="/job_platform/index.php?action=login">Log In</a></li>
                            <li><a href="/job_platform/index.php?action=register">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="sidebar_box">
                    <h2>Contact Us</h2>
                    <p>Looking for your dream job or the perfect candidate?</p>
                    Email: info@jobplatform.com<br />
                    Tel: 010-040-0220
                </div>
            </div>

            <div class="cleaner"></div>
        </div> <!-- end templatmeo_main -->

        <div id="templatemo_footer">
            Copyright &copy; 2026 <a href="#">Job Platform</a> | All rights reserved.
        </div>

    </div>
</div>

</body>
</html>
