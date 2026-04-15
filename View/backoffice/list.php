<?php
$activePage = 'list';
$pageTitle  = 'Gestion des Missions';
$pageIcon   = 'list';

ob_start();
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-briefcase me-2"></i>Liste des Missions</span>
        <a href="index.php?action=create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nouvelle Mission
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($missions)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Aucune mission pour le moment.</p>
                <a href="index.php?action=create" class="btn btn-primary">Ajouter une mission</a>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Budget</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Statut</th>
                        <th>Compétences</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($missions as $m): ?>
                    <tr>
                        <td><?= $m['id'] ?></td>
                        <td><strong><?= htmlspecialchars($m['titre']) ?></strong></td>
                        <td><span class="text-success fw-bold"><?= number_format($m['budget'], 2) ?> €</span></td>
                        <td><?= $m['date_debut'] ?></td>
                        <td><?= $m['date_fin'] ?></td>
                        <td>
                            <span class="badge badge-<?= $m['statut'] ?> px-2 py-1 rounded">
                                <?= ucfirst(str_replace('_', ' ', $m['statut'])) ?>
                            </span>
                        </td>
                        <td><small><?= htmlspecialchars($m['competences']) ?></small></td>
                        <td>
                            <a href="index.php?action=edit&id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?action=candidatures&mission_id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-info me-1" title="Voir candidatures">
                                <i class="fas fa-user-check"></i>
                            </a>
                            <a href="index.php?action=delete&id=<?= $m['id'] ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Supprimer cette mission ?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once 'layout.php';
?>