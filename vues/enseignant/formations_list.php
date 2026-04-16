<?php $pageTitle = 'Mes formations'; require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Mes formations</h1>
    <a href="index.php?role=enseignant&action=formation_add" class="btn btn-primary">+ Nouvelle formation</a>
</div>

<?php if (empty($formations)): ?>
    <div class="empty-state">
        <p>Aucune formation pour l'instant.</p>
        <a href="index.php?role=enseignant&action=formation_add" class="btn btn-primary">Creer la premiere</a>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Lieu</th>
                    <th>Niveau</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Capacite</th>
                    <th>Participants</th>
                    <th>Taches</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formations as $f): ?>
                    <tr>
                        <td><?= (int)$f['id'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($f['titre']) ?></strong>
                            <?php if ($f['description']): ?>
                                <br><small class="text-muted"><?= htmlspecialchars(mb_substr($f['description'], 0, 60)) ?>...</small>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($f['lieu'] ?: '—') ?></td>
                        <td>
                            <span class="badge-niveau <?= $f['niveau'] ?>">
                                <?= Formation::NIVEAUX[$f['niveau']] ?? $f['niveau'] ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($f['date_debut'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($f['date_fin'])) ?></td>
                        <td><?= $f['capacite_max'] > 0 ? (int)$f['capacite_max'] : 'Illimite' ?></td>
                        <td><span class="badge"><?= (int)$f['nb_participants'] ?></span></td>
                        <td><span class="badge"><?= (int)$f['nb_taches'] ?></span></td>
                        <td class="actions-cell">
                            <a href="index.php?role=enseignant&action=taches&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Taches</a>
                            <a href="index.php?role=enseignant&action=participants&formation_id=<?= $f['id'] ?>" class="btn btn-sm btn-outline">Participants</a>
                            <a href="index.php?role=enseignant&action=formation_edit&id=<?= $f['id'] ?>" class="btn btn-sm btn-edit">Modifier</a>
                            <a href="index.php?role=enseignant&action=formation_delete&id=<?= $f['id'] ?>"
                               class="btn btn-sm btn-delete"
                               onclick="return confirm('Supprimer cette formation et toutes ses donnees ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

</main></body></html>
