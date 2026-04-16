<?php $pageTitle = 'Tableau de bord'; require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Tableau de bord</h1>
    <a href="index.php?role=enseignant&action=formation_add" class="btn btn-primary">+ Nouvelle formation</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= (int)$nbFormations ?></div>
        <div class="stat-label">Mes formations</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= (int)$nbParticipants ?></div>
        <div class="stat-label">Participants total</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= (int)$nbTaches ?></div>
        <div class="stat-label">Taches creees</div>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <h2>Mes formations</h2>
        <a href="index.php?role=enseignant&action=formations" class="btn btn-outline">Voir tout</a>
    </div>

    <?php if (empty($formations)): ?>
        <div class="empty-state">
            <p>Aucune formation pour l'instant.</p>
            <a href="index.php?role=enseignant&action=formation_add" class="btn btn-primary">Creer la premiere</a>
        </div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach (array_slice($formations, 0, 4) as $f): ?>
                <div class="formation-card">
                    <div class="card-title"><?= htmlspecialchars($f['titre']) ?></div>
                    <div class="card-meta">
                        <?= htmlspecialchars(Formation::NIVEAUX[$f['niveau']] ?? $f['niveau']) ?>
                        <?php if ($f['lieu']): ?> &bull; <?= htmlspecialchars($f['lieu']) ?><?php endif; ?>
                        <br>
                        <?= date('d/m/Y', strtotime($f['date_debut'])) ?> &rarr; <?= date('d/m/Y', strtotime($f['date_fin'])) ?>
                    </div>
                    <div class="card-stats">
                        <span><?= (int)$f['nb_participants'] ?> participants</span>
                        <span><?= (int)$f['nb_taches'] ?> taches</span>
                        <?php if ($f['capacite_max'] > 0): ?>
                            <span>Max <?= (int)$f['capacite_max'] ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-actions">
                        <a href="index.php?role=enseignant&action=taches&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Taches</a>
                        <a href="index.php?role=enseignant&action=participants&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Participants</a>
                        <a href="index.php?role=enseignant&action=formation_edit&id=<?= $f['id'] ?>" class="btn btn-sm btn-edit">Modifier</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</main></body></html>
