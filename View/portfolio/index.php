<?php
$pageTitle = 'Portfolio';
require_once __DIR__ . '/../../View/layout/pl_dashboard_header.php';

// Consume flash
$flash = $_SESSION['portfolio_flash'] ?? null;
unset($_SESSION['portfolio_flash']);

$userId = (int)($_SESSION['user_id'] ?? 0);
$role   = $_SESSION['user_role'] ?? '';
?>

<div class="ww-page">

<?php if ($flash): ?>
<div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>">
    <i class="fa fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
    <?= htmlspecialchars($flash['msg']) ?>
</div>
<?php endif; ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div>
        <div class="page-header-title">
            <i class="fa fa-folder-open" style="color:#00ffcc;"></i> Portfolio de Projets
        </div>
        <div class="page-header-sub">Découvrez les réalisations de la communauté WorkWave</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
        <a href="/workwave/Controller/index.php?action=portfolio_map" class="ww-btn-secondary" style="margin-top:0;">
            <i class="fa fa-map-marked-alt"></i> Carte des Talents
        </a>
        <?php if ($userId): ?>
        <a href="/workwave/Controller/index.php?action=portfolio_cv" class="ww-btn-secondary" style="margin-top:0;">
            <i class="fa fa-user-tie"></i> Mon CV
        </a>
        <a href="/workwave/Controller/index.php?action=portfolio_add" class="cyber-btn" style="margin-top:0;">
            <i class="fa fa-plus"></i> Ajouter un projet
        </a>
        <?php endif; ?>
        <?php if ($role === 'admin'): ?>
        <a href="/workwave/Controller/index.php?action=portfolio_admin" class="ww-btn-secondary">
            <i class="fa fa-cog"></i> Admin
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== STATS ===== -->
<div class="stat-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-card-label">Total projets</div>
        <div class="stat-card-value"><?= $stats['total'] ?></div>
        <div class="stat-card-sub">Dans la plateforme</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Mes projets</div>
        <div class="stat-card-value"><?= $stats['mine'] ?></div>
        <div class="stat-card-sub">Publiés par moi</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Technologies</div>
        <div class="stat-card-value"><?= $stats['techs'] ?></div>
        <div class="stat-card-sub">Distinct</div>
    </div>
</div>

<!-- ===== SEARCH BAR ===== -->
<form method="GET" action="/workwave/Controller/index.php" style="margin-bottom:28px;">
    <input type="hidden" name="action" value="portfolio">
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <div style="flex:1;min-width:200px;position:relative;">
            <i class="fa fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#00ffcc;opacity:.6;"></i>
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Rechercher un projet…"
                   style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:8px;padding:10px 14px 10px 40px;color:#ddd;outline:none;">
        </div>
        <div style="flex:1;min-width:160px;position:relative;">
            <i class="fa fa-code" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#00ffcc;opacity:.6;"></i>
            <input type="text" name="tech" value="<?= htmlspecialchars($_GET['tech'] ?? '') ?>"
                   placeholder="Technologie (ex: React)"
                   style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:8px;padding:10px 14px 10px 40px;color:#ddd;outline:none;">
        </div>
        <button type="submit" class="cyber-btn" style="padding:10px 20px;height:fit-content;align-self:center;">
            <i class="fa fa-filter"></i> Filtrer
        </button>
        <?php if (!empty($_GET['search']) || !empty($_GET['tech'])): ?>
        <a href="/workwave/Controller/index.php?action=portfolio" class="ww-btn-secondary" style="align-self:center;margin-top:0;">
            <i class="fa fa-times"></i>
        </a>
        <?php endif; ?>
    </div>
</form>

<!-- ===== PROJECTS GRID ===== -->
<?php if (empty($projects)): ?>
<div style="text-align:center;padding:60px 20px;">
    <i class="fa fa-folder-open" style="font-size:56px;color:rgba(0,255,204,.2);margin-bottom:16px;display:block;"></i>
    <h4 style="color:#fff;margin-bottom:8px;">Aucun projet trouvé</h4>
    <p style="color:#666;">
        <?= $userId ? 'Soyez le premier à publier votre réalisation !' : 'Connectez-vous pour ajouter votre premier projet.' ?>
    </p>
    <?php if ($userId): ?>
    <a href="/workwave/Controller/index.php?action=portfolio_add" class="cyber-btn" style="margin-top:16px;display:inline-flex;">
        <i class="fa fa-plus"></i> Ajouter un projet
    </a>
    <?php endif; ?>
</div>
<?php else: ?>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:22px;">
    <?php foreach ($projects as $proj): ?>
    <?php $isOwner = ($proj['user_id'] == $userId); ?>
    <div class="cyber-card" style="display:flex;flex-direction:column;">
        <!-- Thumbnail -->
        <div style="height:180px;overflow:hidden;background:linear-gradient(135deg,rgba(0,255,204,.08),rgba(0,180,255,.08));display:flex;align-items:center;justify-content:center;position:relative;">
            <?php if (!empty($proj['image_path'])): ?>
                <img src="/workwave/<?= htmlspecialchars($proj['image_path']) ?>"
                     alt="<?= htmlspecialchars($proj['title']) ?>"
                     style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                <i class="fa fa-laptop-code" style="font-size:52px;color:rgba(0,255,204,.25);"></i>
            <?php endif; ?>
            <!-- Owner badge -->
            <?php if ($isOwner): ?>
            <span style="position:absolute;top:10px;right:10px;background:rgba(0,255,204,.15);border:1px solid rgba(0,255,204,.4);color:#00ffcc;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                Mon projet
            </span>
            <?php endif; ?>
        </div>

        <!-- Body -->
        <div style="padding:20px;flex:1;display:flex;flex-direction:column;gap:10px;">
            <h4 style="color:#fff;font-size:1rem;font-weight:700;margin:0;">
                <?= htmlspecialchars($proj['title']) ?>
            </h4>

            <!-- Author -->
            <div style="font-size:.78rem;color:#666;display:flex;align-items:center;gap:6px;">
                <i class="fa fa-user" style="color:rgba(0,255,204,.4);"></i>
                <?= htmlspecialchars($proj['first_name'] . ' ' . $proj['last_name']) ?>
                <span style="color:#333;">•</span>
                <?= date('d/m/Y', strtotime($proj['created_at'])) ?>
            </div>

            <!-- Description -->
            <p style="color:rgba(255,255,255,.6);font-size:.83rem;line-height:1.55;margin:0;flex:1;">
                <?= htmlspecialchars(mb_substr($proj['description'] ?? '', 0, 120)) ?>…
            </p>

            <!-- Tech tags -->
            <?php if (!empty($proj['technologies'])): ?>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                <?php foreach (array_slice(explode(',', $proj['technologies']), 0, 4) as $tech): ?>
                <?php $t = trim($tech); if ($t === '') continue; ?>
                <span class="cyber-badge cyber-badge-blue" style="font-size:.7rem;">
                    <?= htmlspecialchars($t) ?>
                </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Actions -->
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:6px;">
                <?php if (!empty($proj['github_url'])): ?>
                <a href="<?= htmlspecialchars($proj['github_url']) ?>" target="_blank" rel="noopener"
                   class="ww-btn-secondary" style="margin-top:0;padding:7px 14px;font-size:.78rem;">
                    <i class="fab fa-github"></i> GitHub
                </a>
                <?php endif; ?>
                <?php if (!empty($proj['demo_url'])): ?>
                <a href="<?= htmlspecialchars($proj['demo_url']) ?>" target="_blank" rel="noopener"
                   class="cyber-btn" style="padding:7px 14px;font-size:.78rem;">
                    <i class="fa fa-external-link-alt"></i> Démo
                </a>
                <?php endif; ?>
                <?php if ($isOwner || $role === 'admin'): ?>
                <a href="/workwave/Controller/index.php?action=portfolio_edit&id=<?= $proj['id'] ?>"
                   class="ww-btn-secondary" style="margin-top:0;padding:7px 14px;font-size:.78rem;">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="/workwave/Controller/index.php?action=portfolio_delete&id=<?= $proj['id'] ?>"
                   class="btn-danger" style="padding:7px 14px;font-size:.78rem;"
                   onclick="return confirm('Supprimer ce projet ?')">
                    <i class="fa fa-trash"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

</div><!-- /.ww-page -->

<?php require_once __DIR__ . '/../../View/layout/pl_dashboard_footer.php'; ?>
