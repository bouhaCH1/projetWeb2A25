<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkWave - L'Élite du Recrutement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Libre+Franklin:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/assets/css/templatemo-aurum-gold.css">
    <style>
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav" id="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="index.php" class="logo">Work<span>Wave</span></a>
                <ul class="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#products">Offres d'emploi</a></li>
                    <li><a href="#products">Portfolios</a></li>
                </ul>
                <div class="nav-cta">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php 
                            $role = strtolower($_SESSION['user']['role'] ?? ''); 
                            if ($role === 'condidat') $role = 'candidat';
                        ?>
                        <a href="index.php?action=<?= $role ?>-dashboard" class="btn btn-outline">Mon Espace</a>
                        <a href="index.php?action=logout" class="btn btn-primary">Déconnexion</a>
                    <?php else: ?>
                        <a href="index.php?action=login" class="btn btn-outline">Connexion</a>
                        <a href="index.php?action=register" class="btn btn-primary">S'inscrire</a>
                    <?php endif; ?>
                </div>
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <button class="mobile-menu-close" id="mobileMenuClose" aria-label="Close Menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <ul class="mobile-nav-links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="#products">Offres d'emploi</a></li>
            <li><a href="#products">Portfolios</a></li>
        </ul>
        <div class="mobile-menu-cta">
            <?php if (isset($_SESSION['user'])): ?>
                <?php 
                    $role = strtolower($_SESSION['user']['role'] ?? ''); 
                    if ($role === 'condidat') $role = 'candidat';
                ?>
                <a href="index.php?action=<?= $role ?>-dashboard" class="btn btn-outline">Mon Espace</a>
                <a href="index.php?action=logout" class="btn btn-primary">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?action=login" class="btn btn-outline">Connexion</a>
                <a href="index.php?action=register" class="btn btn-primary">S'inscrire</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-badge">
                        <span class="dot"></span>
                        Plateforme Premium
                    </div>
                    <h1 class="hero-title">
                        Trouvez le <span class="gold">Talent</span><br>
                        Idéal Aujourd'hui
                    </h1>
                    <p class="hero-desc">
                        Connectez-vous avec les meilleures entreprises ou trouvez les talents parfaits pour vos projets. Une plateforme premium pour des opportunités en or.
                    </p>
                    <div class="hero-actions">
                        <a href="#products" class="btn btn-primary">Voir les offres</a>
                        <?php if (!isset($_SESSION['user'])): ?>
                            <a href="index.php?action=register" class="btn btn-outline">Rejoindre l'élite</a>
                        <?php endif; ?>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-value">500+</div>
                            <div class="stat-label">Entreprises</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">10K+</div>
                            <div class="stat-label">Candidats</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">100%</div>
                            <div class="stat-label">Opportunités</div>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="price-card">
                        <div class="price-header">
                            <span class="price-label">Statistiques WorkWave</span>
                            <span class="price-live">En direct</span>
                        </div>
                        <div class="price-main">
                            <div class="price-value">
                                <span class="currency"></span>124<span style="font-size: 24px;"> Offres Actives</span>
                            </div>
                            <span class="price-change">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 2L10 8H2L6 2Z" fill="currentColor"/>
                                </svg>
                                +12 Nouvelles aujourd'hui
                            </span>
                        </div>
                        <div class="price-metals">
                            <div class="metal-item">
                                <div class="metal-name">Développement Web</div>
                                <div class="metal-price">45 Postes</div>
                                <div class="metal-change">+2%</div>
                            </div>
                            <div class="metal-item">
                                <div class="metal-name">Design & Création</div>
                                <div class="metal-price">32 Postes</div>
                                <div class="metal-change">+5%</div>
                            </div>
                            <div class="metal-item">
                                <div class="metal-name">Marketing Digital</div>
                                <div class="metal-price">28 Postes</div>
                                <div class="metal-change down">-1%</div>
                            </div>
                            <div class="metal-item">
                                <div class="metal-name">Gestion de Projet</div>
                                <div class="metal-price">19 Postes</div>
                                <div class="metal-change">+4%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products" id="products">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Découvrir</div>
                <h2 class="section-title">Nos Opportunités & Talents</h2>
                <p class="section-desc">Explorez les dernières offres d'emploi ou découvrez les portfolios des meilleurs candidats sur notre plateforme.</p>
            </div>
            <div class="products-tabs">
                <button class="tab-btn active" data-tab="offres">Offres d'emploi</button>
                <button class="tab-btn" data-tab="portfolios">Portfolios</button>
            </div>

            <!-- Offres Tab -->
            <div class="products-tab-content active" id="tab-offres">
                <?php if (empty($jobs)): ?>
                    <p style="text-align: center; width: 100%; color: #a0a0a0;">Aucune offre d'emploi disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="product-card">
                            <div class="product-image" style="height: 150px; background: #222; display: flex; align-items: center; justify-content: center;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-main)" stroke-width="1.5">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name" style="margin-bottom: 5px;"><?= htmlspecialchars($job['title']) ?></h3>
                                <div class="product-weight" style="color: var(--gold-light); margin-bottom: 10px;"><?= htmlspecialchars($job['company_name']) ?></div>
                                <p style="color: #a0a0a0; font-size: 0.9rem; margin-bottom: 15px;"><?= htmlspecialchars(substr($job['description'], 0, 80)) ?>...</p>
                                <div class="product-footer" style="margin-top: auto;">
                                    <span class="product-price" style="font-size: 1rem; color: #fff;"><?= date('d/m/Y', strtotime($job['created_at'])) ?></span>
                                    <?php 
                                        $currentRole = isset($_SESSION['user']) ? strtolower($_SESSION['user']['role'] ?? '') : '';
                                        if ($currentRole === 'client' || $currentRole === 'condidat') $currentRole = 'candidat';
                                    ?>
                                    <?php if ($currentRole === 'candidat'): ?>
                                        <a href="index.php?action=candidat-job-detail&id=<?= $job['id'] ?>" class="product-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; width: auto; padding: 0 15px; border-radius: 4px; font-size: 0.9rem;">Postuler</a>
                                    <?php elseif (!isset($_SESSION['user'])): ?>
                                        <a href="index.php?action=login" class="product-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; width: auto; padding: 0 15px; border-radius: 4px; font-size: 0.9rem;" title="Connectez-vous pour postuler">Connexion</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Portfolios Tab -->
            <div class="products-tab-content" id="tab-portfolios">
                <?php if (empty($portfolios)): ?>
                    <p style="text-align: center; width: 100%; color: #a0a0a0;">Aucun portfolio disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($portfolios as $p): ?>
                        <div class="product-card">
                            <div class="product-image" style="height: 150px; background: #222; display: flex; align-items: center; justify-content: center;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gold-main)" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="product-info">
                                <div style="font-size: 0.8rem; color: var(--gold-main); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;"><?= htmlspecialchars($p['category']) ?></div>
                                <h3 class="product-name" style="margin-bottom: 5px;"><?= htmlspecialchars($p['title']) ?></h3>
                                <div class="product-weight" style="color: #fff; margin-bottom: 10px;"><?= htmlspecialchars($p['username']) ?> <?= $p['user_company'] ? '('.htmlspecialchars($p['user_company']).')' : '' ?></div>
                                <p style="color: #a0a0a0; font-size: 0.9rem; margin-bottom: 15px;"><?= htmlspecialchars(substr($p['description'], 0, 80)) ?>...</p>
                                <div class="product-footer" style="margin-top: auto;">
                                    <span class="product-price" style="font-size: 1rem; color: #fff;">Premium</span>
                                    <a href="index.php?action=front-detail&id=<?= $p['id'] ?>" class="product-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; width: auto; padding: 0 15px; border-radius: 4px; font-size: 0.9rem;">Voir</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">Work<span>Wave</span></a>
                    <p>Votre partenaire de confiance pour le recrutement et la mise en relation professionnelle. Nous connectons les talents et les entreprises du monde entier.</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="#products">Offres d'emploi</a></li>
                        <li><a href="#products">Portfolios</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Légal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Conditions Générales</a></li>
                        <li><a href="#">Politique de Confidentialité</a></li>
                        <li><a href="#">Mentions Légales</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Contact</h4>
                    <ul class="footer-links">
                        <li><a href="#">contact@workwave.com</a></li>
                        <li><a href="#">Support Client</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-copy">&copy; 2026 WorkWave. Tous droits réservés.</p>
                <div class="footer-socials">
                    <a href="#" class="social-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="view/assets/js/templatemo-aurum-script.js"></script>
</body>
</html>
