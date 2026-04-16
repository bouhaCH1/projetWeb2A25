<?php $pageTitle = 'Tableau de bord'; require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Tableau de bord</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= count($mesFormations) ?></div>
        <div class="stat-label">Mes formations</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= count($touteFormations) ?></div>
        <div class="stat-label">Formations disponibles</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= count($mesTaches) ?></div>
        <div class="stat-label">Mes taches</div>
    </div>
</div>

<!-- Mes formations -->
<div class="section">
    <div class="section-header">
        <h2>Mes formations</h2>
        <a href="index.php?role=etudiant&action=formations" class="btn btn-outline">Voir tout</a>
    </div>

    <?php if (empty($mesFormations)): ?>
        <div class="empty-state">
            <p>Vous ne participez a aucune formation.</p>
            <a href="index.php?role=etudiant&action=formations" class="btn btn-primary">Rejoindre une formation</a>
        </div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach (array_slice($mesFormations, 0, 3) as $f): ?>
                <div class="formation-card card-enrolled">
                    <div class="card-title"><?= htmlspecialchars($f['titre']) ?></div>
                    <div class="card-meta">
                        Enseignant : <?= htmlspecialchars($f['ens_prenom'].' '.$f['ens_nom']) ?><br>
                        <?= date('d/m/Y', strtotime($f['date_debut'])) ?> &rarr; <?= date('d/m/Y', strtotime($f['date_fin'])) ?>
                    </div>
                    <div class="card-actions">
                        <a href="index.php?role=etudiant&action=taches&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">
                            Mes taches (<?= (int)$f['nb_taches'] ?>)
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Mes taches recentes -->
<?php if (!empty($mesTaches)): ?>
<div class="section">
    <div class="section-header">
        <h2>Mes taches recentes</h2>
        <a href="index.php?role=etudiant&action=taches" class="btn btn-outline">Voir tout</a>
    </div>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr><th>Tache</th><th>Formation</th><th>Duree</th><th>Echeance</th><th>Mon statut</th></tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($mesTaches, 0, 5) as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['titre']) ?></td>
                        <td><?= htmlspecialchars($t['formation_titre']) ?></td>
                        <td><?= (int)$t['duree'] ?>h</td>
                        <td><?= date('d/m/Y', strtotime($t['date_fin'])) ?></td>
                        <td>
                            <span class="statut-badge statut-<?= $t['mon_statut'] ?>">
                                <?= Tache::STATUTS[$t['mon_statut']] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

</main></body></html>
