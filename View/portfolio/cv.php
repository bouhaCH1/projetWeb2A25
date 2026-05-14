<?php
$pageTitle = 'Mon CV Portfolio';
require_once __DIR__ . '/../../View/layout/pl_dashboard_header.php';

$flash = $_SESSION['portfolio_flash'] ?? null;
unset($_SESSION['portfolio_flash']);
?>

<div class="ww-page">

<?php if ($flash): ?>
<div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>">
    <i class="fa fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
    <?= htmlspecialchars($flash['msg']) ?>
</div>
<?php endif; ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <div class="page-header-title">
            <i class="fa fa-user-tie" style="color:#00ffcc;"></i> Mon CV
        </div>
        <div class="page-header-sub">Gérez vos compétences, diplômes et certifications</div>
    </div>
    <a href="/workwave/Controller/index.php?action=portfolio" class="ww-btn-secondary" style="margin-top:0;">
        <i class="fa fa-arrow-left"></i> Retour au Portfolio
    </a>
</div>

<div class="row g-4">
    <!-- COLONNE GAUCHE: Formulaires d'ajout -->
    <div class="col-lg-4">
        
        <!-- Ajouter Compétence -->
        <div class="dsh-card mb-4">
            <h5 style="color:#00ffcc;font-size:1.05rem;font-weight:700;margin-bottom:15px;">
                <i class="fa fa-star me-2"></i> Ajouter une compétence
            </h5>
            <form method="POST" action="/workwave/Controller/index.php?action=portfolio_cv_add">
                <input type="hidden" name="type" value="skill">
                <input type="text" name="name" placeholder="Ex: React.js" required style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:8px 12px;color:#ddd;margin-bottom:10px;">
                <select name="level" required style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:8px 12px;color:#ddd;margin-bottom:10px;">
                    <option value="1">Débutant (1/5)</option>
                    <option value="2">Intermédiaire (2/5)</option>
                    <option value="3">Bon (3/5)</option>
                    <option value="4">Très bon (4/5)</option>
                    <option value="5">Expert (5/5)</option>
                </select>
                <button type="submit" class="cyber-btn" style="width:100%;justify-content:center;padding:8px;font-size:0.9rem;">
                    <i class="fa fa-plus"></i> Ajouter
                </button>
            </form>
        </div>

        <!-- Ajouter Diplôme -->
        <div class="dsh-card mb-4">
            <h5 style="color:#00ffcc;font-size:1.05rem;font-weight:700;margin-bottom:15px;">
                <i class="fa fa-graduation-cap me-2"></i> Ajouter un diplôme
            </h5>
            <form method="POST" action="/workwave/Controller/index.php?action=portfolio_cv_add">
                <input type="hidden" name="type" value="diploma">
                <input type="text" name="title" placeholder="Ex: Licence en Informatique" required style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:8px 12px;color:#ddd;margin-bottom:10px;">
                <input type="text" name="institution" placeholder="Ex: Université de Tunis" required style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:8px 12px;color:#ddd;margin-bottom:10px;">
                <input type="number" name="graduation_year" placeholder="Année (ex: 2023)" required min="1950" max="2030" style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:8px 12px;color:#ddd;margin-bottom:10px;">
                <button type="submit" class="cyber-btn" style="width:100%;justify-content:center;padding:8px;font-size:0.9rem;">
                    <i class="fa fa-plus"></i> Ajouter
                </button>
            </form>
        </div>

        <!-- Ajouter Certification -->
        <div class="dsh-card mb-4">
            <h5 style="color:#00ffcc;font-size:1.05rem;font-weight:700;margin-bottom:15px;">
                <i class="fa fa-certificate me-2"></i> Ajouter une certification
            </h5>
            <form method="POST" action="/workwave/Controller/index.php?action=portfolio_cv_add" enctype="multipart/form-data">
                <input type="hidden" name="type" value="certificate">
                <input type="text" name="title" placeholder="Ex: AWS Certified Developer" required style="width:100%;background:rgba(255,255,255,.04);border:1px solid rgba(0,255,204,.15);border-radius:6px;padding:8px 12px;color:#ddd;margin-bottom:10px;">
                <input type="file" name="file" required accept=".pdf,image/*" style="margin-bottom:10px;">
                <button type="submit" class="cyber-btn" style="width:100%;justify-content:center;padding:8px;font-size:0.9rem;">
                    <i class="fa fa-plus"></i> Ajouter
                </button>
            </form>
        </div>

    </div>

    <!-- COLONNE DROITE: Liste -->
    <div class="col-lg-8">
        
        <!-- Liste Compétences -->
        <div class="dsh-card mb-4">
            <h5 style="color:#fff;font-size:1.1rem;font-weight:700;margin-bottom:20px;border-bottom:1px solid rgba(0,255,204,0.1);padding-bottom:10px;">Mes Compétences</h5>
            <?php if (empty($skills)): ?>
                <p class="text-muted small">Aucune compétence ajoutée.</p>
            <?php else: ?>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php foreach ($skills as $s): ?>
                        <div style="background:rgba(0,255,204,0.08);border:1px solid rgba(0,255,204,0.2);padding:6px 12px;border-radius:20px;display:flex;align-items:center;gap:10px;">
                            <span style="color:#fff;font-weight:600;font-size:0.9rem;"><?= htmlspecialchars($s['name']) ?></span>
                            <span style="color:#00ffcc;font-size:0.8rem;"><?= str_repeat('★', $s['level']) ?><?= str_repeat('☆', 5 - $s['level']) ?></span>
                            <a href="/workwave/Controller/index.php?action=portfolio_cv_del&type=skill&id=<?= $s['id'] ?>" style="color:#ff6b6b;margin-left:5px;" title="Supprimer" onclick="return confirm('Supprimer ?')"><i class="fa fa-times"></i></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Liste Diplômes -->
        <div class="dsh-card mb-4">
            <h5 style="color:#fff;font-size:1.1rem;font-weight:700;margin-bottom:20px;border-bottom:1px solid rgba(0,255,204,0.1);padding-bottom:10px;">Mes Diplômes</h5>
            <?php if (empty($diplomas)): ?>
                <p class="text-muted small">Aucun diplôme ajouté.</p>
            <?php else: ?>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <?php foreach ($diplomas as $d): ?>
                        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);padding:12px 16px;border-radius:8px;display:flex;justify-content:space-between;align-items:center;">
                            <div>
                                <div style="color:#00ffcc;font-weight:700;font-size:1rem;margin-bottom:4px;"><?= htmlspecialchars($d['title']) ?></div>
                                <div style="color:#aaa;font-size:0.85rem;"><i class="fa fa-university me-1"></i> <?= htmlspecialchars($d['institution']) ?> • <i class="fa fa-calendar-alt ms-2 me-1"></i> <?= $d['graduation_year'] ?></div>
                            </div>
                            <a href="/workwave/Controller/index.php?action=portfolio_cv_del&type=diploma&id=<?= $d['id'] ?>" class="btn-danger" style="padding:6px 12px;" onclick="return confirm('Supprimer ?')"><i class="fa fa-trash"></i></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Liste Certifications -->
        <div class="dsh-card mb-4">
            <h5 style="color:#fff;font-size:1.1rem;font-weight:700;margin-bottom:20px;border-bottom:1px solid rgba(0,255,204,0.1);padding-bottom:10px;">Mes Certifications</h5>
            <?php if (empty($certificates)): ?>
                <p class="text-muted small">Aucune certification ajoutée.</p>
            <?php else: ?>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <?php foreach ($certificates as $c): ?>
                        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);padding:12px 16px;border-radius:8px;display:flex;justify-content:space-between;align-items:center;">
                            <div>
                                <div style="color:#00ffcc;font-weight:700;font-size:1rem;margin-bottom:4px;"><?= htmlspecialchars($c['title']) ?></div>
                                <?php if($c['file_path']): ?>
                                    <a href="/workwave/<?= htmlspecialchars($c['file_path']) ?>" target="_blank" style="color:#00b3ff;font-size:0.85rem;text-decoration:none;"><i class="fa fa-external-link-alt me-1"></i> Voir le fichier</a>
                                <?php endif; ?>
                            </div>
                            <a href="/workwave/Controller/index.php?action=portfolio_cv_del&type=certificate&id=<?= $c['id'] ?>" class="btn-danger" style="padding:6px 12px;" onclick="return confirm('Supprimer ?')"><i class="fa fa-trash"></i></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

</div>

<?php require_once __DIR__ . '/../../View/layout/pl_dashboard_footer.php'; ?>
