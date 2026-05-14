<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>

<section class="dashboard-section">
    <div class="ww-section">
        <?php if (!$portfolio || (int)($portfolio['is_approved'] ?? 0) !== 1): ?>
            <div class="ww-card">
                <h1>Portfolio non disponible</h1>
                <p class="ww-muted">Ce portfolio n'est pas encore validé ou n'existe plus.</p>
                <a href="index.php?action=front-list" class="btn">Retour aux portfolios</a>
            </div>
        <?php else: ?>
            <article class="detail-card">
                <span class="ww-pill"><?= htmlspecialchars($portfolio['category'] ?? 'Portfolio') ?></span>
                <h1><?= htmlspecialchars($portfolio['title']) ?></h1>
                <p class="ww-muted">
                    Par <?= htmlspecialchars($portfolio['submitted_by']) ?>
                    <?= !empty($portfolio['company_name']) ? ' - ' . htmlspecialchars($portfolio['company_name']) : '' ?>
                </p>

                <h4>Description</h4>
                <p><?= nl2br(htmlspecialchars($portfolio['description'])) ?></p>

                <h4>Technologies</h4>
                <div>
                    <?php foreach (explode(',', $portfolio['technologies'] ?? '') as $tech): ?>
                        <?php if (trim($tech) !== ''): ?>
                            <span class="tech-badge"><?= htmlspecialchars(trim($tech)) ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:24px;">
                    <?php if (!empty($portfolio['project_url'])): ?>
                        <a href="<?= htmlspecialchars($portfolio['project_url']) ?>" target="_blank" class="btn">Voir le projet</a>
                    <?php endif; ?>
                    <a href="index.php?action=login" class="btn btn-outline">Contacter ce talent</a>
                    <a href="index.php?action=front-list" class="btn btn-outline">Retour</a>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>

<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
