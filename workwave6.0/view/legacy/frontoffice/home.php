<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

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
            <h1>WorkWave<br>Talents & Opportunités</h1>
            <p>Connectez les meilleurs candidats avec les entreprises qui recrutent, dans une expérience claire construite uniquement sur le template général.</p>
            <a href="#opportunites" class="cta-button">Explorer</a>
        </div>

        <div class="hero-visual">
            <div class="dashboard-preview">
                <div class="preview-header">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
                <div class="preview-content">
                    <div class="chart-container">
                        <div class="bar-chart">
                            <div class="bar" style="height: 68%"></div>
                            <div class="bar" style="height: 45%"></div>
                            <div class="bar" style="height: 82%"></div>
                            <div class="bar" style="height: 58%"></div>
                            <div class="bar" style="height: 74%"></div>
                        </div>
                    </div>
                    <div class="metrics-grid">
                        <div class="metric-item">
                            <div class="metric-value"><?= count($jobs ?? []) ?></div>
                            <div class="metric-label">Offres</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value"><?= count($portfolios ?? []) ?></div>
                            <div class="metric-label">Portfolios</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dashboard-section" id="opportunites">
    <div class="ww-section">
        <h2 class="section-title">Offres d'emploi</h2>
        <?php if (!empty($databaseError)): ?>
            <div class="alert">La base de données est en cours de démarrage. Les offres et portfolios apparaîtront après le redémarrage complet de MySQL.</div>
        <?php endif; ?>

        <div class="ww-grid">
            <?php if (empty($jobs)): ?>
                <div class="ww-card">
                    <h3>Aucune offre disponible</h3>
                    <p class="ww-muted">Revenez après la validation des premières offres.</p>
                </div>
            <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                    <article class="ww-card">
                        <span class="ww-pill"><?= htmlspecialchars($job['company_name'] ?? 'Entreprise') ?></span>
                        <h3><?= htmlspecialchars($job['title'] ?? 'Offre') ?></h3>
                        <p class="ww-muted"><?= htmlspecialchars(substr($job['description'] ?? '', 0, 130)) ?>...</p>
                        <a href="<?= isset($_SESSION['user']) ? 'index.php?action=candidat-job-detail&id=' . (int)$job['id'] : 'index.php?action=login' ?>" class="btn">
                            <?= isset($_SESSION['user']) ? 'Voir l’offre' : 'Se connecter' ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="analytics-section">
    <div class="ww-section">
        <h2 class="section-title">Portfolios validés</h2>
        <div class="ww-grid">
            <?php if (empty($portfolios)): ?>
                <div class="ww-card">
                    <h3>Aucun portfolio disponible</h3>
                    <p class="ww-muted">Les talents validés seront affichés ici.</p>
                </div>
            <?php else: ?>
                <?php foreach ($portfolios as $portfolio): ?>
                    <article class="ww-card">
                        <span class="ww-pill"><?= htmlspecialchars($portfolio['category'] ?? 'Portfolio') ?></span>
                        <h3><?= htmlspecialchars($portfolio['title'] ?? 'Portfolio') ?></h3>
                        <p class="ww-muted">Par <?= htmlspecialchars($portfolio['username'] ?? $portfolio['submitted_by'] ?? 'Talent') ?></p>
                        <p class="ww-muted"><?= htmlspecialchars(substr($portfolio['description'] ?? '', 0, 120)) ?>...</p>
                        <a href="index.php?action=front-detail&id=<?= (int)$portfolio['id'] ?>" class="btn btn-outline">Voir</a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
