<?php $pageTitle = 'Formations'; require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Formations disponibles</h1>
</div>

<div class="tabs">
    <button class="tab active" onclick="showTab('toutes', this)">Toutes (<?= count($touteFormations) ?>)</button>
    <button class="tab" onclick="showTab('mes', this)">Mes formations (<?= count($mesFormations) ?>)</button>
</div>

<!-- Toutes les formations -->
<div id="tab-toutes" class="tab-content active">
    <?php if (empty($touteFormations)): ?>
        <div class="empty-state"><p>Aucune formation disponible.</p></div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($touteFormations as $f):
                $inscrit = in_array((int)$f['id'], array_map('intval', $mesIds));
            ?>
                <div class="formation-card <?= $inscrit ? 'card-enrolled' : '' ?>">
                    <div class="card-title"><?= htmlspecialchars($f['titre']) ?></div>
                    <div class="card-meta">
                        Enseignant : <?= htmlspecialchars($f['ens_prenom'].' '.$f['ens_nom']) ?><br>
                        <?php if ($f['lieu']): ?><?= htmlspecialchars($f['lieu']) ?><br><?php endif; ?>
                        <span class="badge-niveau <?= $f['niveau'] ?>"><?= Formation::NIVEAUX[$f['niveau']] ?></span><br>
                        <?= date('d/m/Y', strtotime($f['date_debut'])) ?> &rarr; <?= date('d/m/Y', strtotime($f['date_fin'])) ?><br>
                        <?= (int)$f['nb_participants'] ?> participants
                        <?php if ($f['capacite_max'] > 0): ?>
                            / <?= (int)$f['capacite_max'] ?> places
                        <?php endif; ?>
                    </div>
                    <?php if ($f['description']): ?>
                        <p class="card-desc"><?= htmlspecialchars(mb_substr($f['description'], 0, 100)) ?>...</p>
                    <?php endif; ?>
                    <div class="card-actions">
                        <?php if ($inscrit): ?>
                            <span class="badge-enrolled">Inscrit</span>
                            <a href="index.php?role=etudiant&action=taches&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Mes taches</a>
                            <a href="index.php?role=etudiant&action=quitter&formation_id=<?= $f['id'] ?>"
                               class="btn btn-sm btn-delete"
                               onclick="return confirm('Quitter cette formation ?')">Quitter</a>
                        <?php else: ?>
                            <a href="index.php?role=etudiant&action=participer&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-primary">Rejoindre</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Mes formations -->
<div id="tab-mes" class="tab-content">
    <?php if (empty($mesFormations)): ?>
        <div class="empty-state"><p>Vous ne participez a aucune formation.</p></div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($mesFormations as $f): ?>
                <div class="formation-card card-enrolled">
                    <div class="card-title"><?= htmlspecialchars($f['titre']) ?></div>
                    <div class="card-meta">
                        Enseignant : <?= htmlspecialchars($f['ens_prenom'].' '.$f['ens_nom']) ?><br>
                        <?= date('d/m/Y', strtotime($f['date_debut'])) ?> &rarr; <?= date('d/m/Y', strtotime($f['date_fin'])) ?>
                    </div>
                    <div class="card-actions">
                        <a href="index.php?role=etudiant&action=taches&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Taches (<?= (int)$f['nb_taches'] ?>)</a>
                        <a href="index.php?role=etudiant&action=quitter&formation_id=<?= $f['id'] ?>"
                           class="btn btn-sm btn-delete"
                           onclick="return confirm('Quitter cette formation ?')">Quitter</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function showTab(name, btn) {
    document.querySelectorAll('.tab-content').forEach(function(el){ el.classList.remove('active'); });
    document.querySelectorAll('.tab').forEach(function(el){ el.classList.remove('active'); });
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

</main></body></html>
