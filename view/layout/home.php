<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="geometric-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
        <div class="shape shape4"></div>
        <div class="shape shape5"></div>
        <div class="shape shape6"></div>
    </div>
    
    <div class="hero-content">
        <div class="hero-text">
            <h1>Trouvez le <br><span style="color: #00ffcc;">job de vos rêves</span><br>ou recrutez des talents</h1>
            <p>WorkWave rassemble chercheurs d'emploi et employeurs sur une seule plateforme intelligente. Créez votre profil, publiez des offres et soyez recruté — tout au même endroit.</p>
            
            <div style="margin-top: 30px; display: flex; gap: 15px; flex-wrap: wrap;">
            <?php if (empty($_SESSION['user_id'])): ?>
                <a href="/workwave/Controller/index.php?action=register" class="cta-button">Commencer gratuitement</a>
                <a href="/workwave/Controller/index.php?action=login" style="padding: 12px 24px; border: 1px solid #00ffcc; color: #00ffcc; border-radius: 8px; font-weight: bold; text-decoration: none; transition: 0.3s;" onmouseover="this.style.background='rgba(0,255,204,0.1)'" onmouseout="this.style.background='transparent'">Se connecter</a>
            <?php else: ?>
                <?php if (($_SESSION['user_role'] ?? '') === 'job_seeker'): ?>
                    <a href="/workwave/Controller/index.php?action=dashboard_seeker" class="cta-button">Aller au tableau de bord</a>
                <?php elseif (($_SESSION['user_role'] ?? '') === 'employer'): ?>
                    <a href="/workwave/Controller/index.php?action=dashboard_employer" class="cta-button">Aller au tableau de bord</a>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        </div>
        
        <div class="hero-visual">
            <div class="city-container">
                <div class="building building1">
                    <div class="building-fill"></div>
                    <div class="building-windows"></div>
                </div>
                <div class="building building2">
                    <div class="building-fill"></div>
                    <div class="building-windows"></div>
                </div>
                <div class="building building3">
                    <div class="building-fill"></div>
                    <div class="building-windows"></div>
                </div>
                <div class="building building4">
                    <div class="building-fill"></div>
                    <div class="building-windows"></div>
                </div>
                <div class="neon-line neon-line1"></div>
                <div class="neon-line neon-line2"></div>
            </div>
        </div>
    </div>
</section>

<!-- Reports Section (Used as Features) -->
<section class="reports-section" id="reports">
    <div class="dashboard-container">
        <h2 class="section-title">Solutions complètes de recrutement</h2>
        <div class="info-grid">
            <div class="info-card">
                <div class="info-icon">💼</div>
                <h3 class="info-title">Trouver un emploi</h3>
                <div class="info-value">Facile</div>
                <p style="font-size: 14px; color: #a0a0a0;">Parcourez des centaines d'offres actives dans tous les secteurs. Filtrez par lieu, salaire et type de contrat.</p>
            </div>
            <div class="info-card">
                <div class="info-icon">📱</div>
                <h3 class="info-title">Créer un profil</h3>
                <div class="info-value">Pro</div>
                <p style="font-size: 14px; color: #a0a0a0;">Créez un profil complet mettant en valeur vos compétences, votre expérience et vos réalisations.</p>
            </div>
            <div class="info-card">
                <div class="info-icon">🌍</div>
                <h3 class="info-title">Publier une offre</h3>
                <div class="info-value">Rapide</div>
                <p style="font-size: 14px; color: #a0a0a0;">Les employeurs peuvent publier des offres détaillées en quelques minutes et trouver des candidats.</p>
            </div>
            <div class="info-card">
                <div class="info-icon">🚀</div>
                <h3 class="info-title">Être recruté</h3>
                <div class="info-value">100%</div>
                <p style="font-size: 14px; color: #a0a0a0;">Notre plateforme garantit un processus de recrutement sûr, rapide et transparent.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section (Used as CTA) -->
<section class="contact-section" id="contact" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="dashboard-container">
        <h2 class="section-title" style="text-align: center;">Commencez à bâtir votre Carrière aujourd'hui</h2>
        <p style="text-align: center; color: #a0a0a0; max-width: 600px; margin: 0 auto 40px auto; font-size: 16px;">
            Que vous soyez débutant ou professionnel expérimenté — ou une entreprise cherchant à recruter — WorkWave est prêt à vous aider à atteindre vos objectifs.
        </p>
        
        <?php if (empty($_SESSION['user_id'])): ?>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="/workwave/Controller/index.php?action=register" class="cta-button">Créer un compte</a>
                <a href="/workwave/Controller/index.php?action=login" style="padding: 12px 24px; border: 1px solid #00ffcc; color: #00ffcc; border-radius: 8px; font-weight: bold; text-decoration: none; transition: 0.3s;" onmouseover="this.style.background='rgba(0,255,204,0.1)'" onmouseout="this.style.background='transparent'">Déjà un compte ?</a>
            </div>
        <?php endif; ?>
    </div>
</section>
