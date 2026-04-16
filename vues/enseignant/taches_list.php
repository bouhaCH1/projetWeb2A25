<?php
$pageTitle = 'Taches — ' . htmlspecialchars($formation['titre']);
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h1>Taches &mdash; <?= htmlspecialchars($formation['titre']) ?></h1>
    <div>
        <a href="index.php?role=enseignant&action=formations" class="btn btn-outline">&larr; Formations</a>
        <a href="index.php?role=enseignant&action=tache_add&formation_id=<?= (int)$formationId ?>" class="btn btn-primary">+ Ajouter une tache</a>
    </div>
</div>

<?php if (empty($taches)): ?>
    <div class="empty-state">
        <p>Aucune tache pour cette formation.</p>
        <a href="index.php?role=enseignant&action=tache_add&formation_id=<?= (int)$formationId ?>" class="btn btn-primary">Ajouter la premiere tache</a>
    </div>
<?php else: ?>

    <?php foreach ($taches as $t): ?>
        <div class="tache-block">
            <div class="tache-block-header">
                <div>
                    <span class="tache-titre"><?= htmlspecialchars($t['titre']) ?></span>
                    <span class="tache-meta-inline">
                        <?= (int)$t['duree'] ?>h &bull;
                        <?= date('d/m/Y', strtotime($t['date_debut'])) ?> &rarr; <?= date('d/m/Y', strtotime($t['date_fin'])) ?>
                    </span>
                    <?php if ($t['description']): ?>
                        <p class="tache-desc"><?= htmlspecialchars($t['description']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="card-actions">
                    <a href="index.php?role=enseignant&action=tache_edit&id=<?= $t['id'] ?>" class="btn btn-sm btn-edit">Modifier</a>
                    <a href="index.php?role=enseignant&action=tache_delete&id=<?= $t['id'] ?>"
                       class="btn btn-sm btn-delete"
                       onclick="return confirm('Supprimer cette tache ?')">Supprimer</a>
                </div>
            </div>

            <!-- Statuts par etudiant -->
            <?php if (!empty($t['statuts'])): ?>
                <div class="statuts-table-wrap">
                    <table class="table statuts-table">
                        <thead>
                            <tr>
                                <th>Etudiant</th>
                                <th>Statut</th>
                                <th>Mis a jour</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($t['statuts'] as $s): ?>
                                <tr>
                                    <td><?= htmlspecialchars($s['prenom'] . ' ' . $s['nom']) ?></td>
                                    <td>
                                        <span class="statut-badge statut-<?= $s['statut'] ?>">
                                            <?= Tache::STATUTS[$s['statut']] ?>
                                        </span>
                                    </td>
                                    <td class="text-muted" style="font-size:0.8rem;">—</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted" style="font-size:0.85rem;padding:8px 0;">Aucun participant inscrit.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

</main></body></html>
