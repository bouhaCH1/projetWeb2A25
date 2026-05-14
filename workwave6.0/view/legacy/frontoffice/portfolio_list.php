<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<section class="dashboard-section">
    <div class="ww-section">
        <h1 class="section-title">Portfolios mis en avant</h1>
        <p class="ww-muted">Des projets validés par l'équipe WorkWave pour aider les entreprises à repérer les bons talents.</p>

        <div class="ww-grid">
            <?php if (empty($portfolios)): ?>
                <div class="ww-card">
                    <h3>Aucun portfolio disponible</h3>
                    <p class="ww-muted">Les portfolios approuvés apparaîtront ici.</p>
                </div>
            <?php else: ?>
                <?php foreach ($portfolios as $portfolio): ?>
                    <article class="ww-card">
                        <span class="ww-pill"><?= htmlspecialchars($portfolio['category'] ?? 'Portfolio') ?></span>
                        <h3><?= htmlspecialchars($portfolio['title'] ?? 'Portfolio') ?></h3>
                        <p class="ww-muted">Par <?= htmlspecialchars($portfolio['submitted_by'] ?? $portfolio['username'] ?? 'Talent') ?></p>
                        <p><?= htmlspecialchars(substr($portfolio['description'] ?? '', 0, 130)) ?>...</p>
                        <div>
                            <?php foreach (array_slice(explode(',', $portfolio['technologies'] ?? ''), 0, 3) as $tech): ?>
                                <?php if (trim($tech) !== ''): ?>
                                    <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <a href="index.php?action=front-detail&id=<?= (int)$portfolio['id'] ?>" class="btn">Voir le portfolio</a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
