<?php
$pageTitle = 'Admin — Portfolios';
require_once __DIR__ . '/../../View/layout/dashboard_header.php';
?>

<div class="container-fluid pt-4 px-4">

<!-- PAGE HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="text-white mb-1"><i class="fa fa-folder-open text-primary me-2"></i>Gestion des Portfolios</h4>
        <small class="text-muted">Tous les projets publiés par les utilisateurs</small>
    </div>
    <a href="/workwave/Controller/index.php?action=portfolio" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left me-1"></i> Retour
    </a>
</div>

<!-- STATS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-3">
        <div class="rounded p-3 text-center">
            <div style="font-size:2rem;font-weight:800;color:#00ffcc;"><?= $stats['total'] ?></div>
            <div class="text-muted small">Projets total</div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="rounded p-3 text-center">
            <div style="font-size:2rem;font-weight:800;color:#00ccff;"><?= $stats['users'] ?></div>
            <div class="text-muted small">Auteurs distincts</div>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="rounded p-3">
    <table class="table table-dark table-hover align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Projet</th>
                <th>Auteur</th>
                <th>Technologies</th>
                <th>Date</th>
                <th>Liens</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($projects)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Aucun projet publié.</td></tr>
        <?php else: ?>
        <?php foreach ($projects as $p): ?>
        <tr>
            <td class="text-muted small"><?= $p['id'] ?></td>
            <td>
                <div style="font-weight:600;color:#fff;"><?= htmlspecialchars($p['title']) ?></div>
                <div class="text-muted small"><?= htmlspecialchars(mb_substr($p['description'] ?? '', 0, 60)) ?>…</div>
            </td>
            <td>
                <div style="color:#ddd;font-size:.85rem;"><?= htmlspecialchars($p['first_name'].' '.$p['last_name']) ?></div>
                <div class="text-muted small"><?= htmlspecialchars($p['email']) ?></div>
            </td>
            <td>
                <?php foreach (array_slice(explode(',', $p['technologies']), 0, 3) as $t): ?>
                <?php $t = trim($t); if (!$t) continue; ?>
                <span class="badge" style="background:rgba(0,204,255,.15);color:#00ccff;font-size:.7rem;"><?= htmlspecialchars($t) ?></span>
                <?php endforeach; ?>
            </td>
            <td class="text-muted small"><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
            <td>
                <?php if (!empty($p['github_url'])): ?>
                <a href="<?= htmlspecialchars($p['github_url']) ?>" target="_blank" class="text-muted" title="GitHub">
                    <i class="fab fa-github"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($p['demo_url'])): ?>
                <a href="<?= htmlspecialchars($p['demo_url']) ?>" target="_blank" class="text-info ms-2" title="Démo">
                    <i class="fa fa-external-link-alt"></i>
                </a>
                <?php endif; ?>
            </td>
            <td>
                <a href="/workwave/Controller/index.php?action=portfolio_edit&id=<?= $p['id'] ?>"
                   class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="/workwave/Controller/index.php?action=portfolio_delete&id=<?= $p['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Supprimer ce projet définitivement ?')" title="Supprimer">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</div>

<?php require_once __DIR__ . '/../../View/layout/dashboard_footer.php'; ?>
