<?php
$activePage = 'list';
$pageTitle  = 'Gestion des Missions';
$pageIcon   = 'list';

ob_start();
?>

<div class="bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Liste des Missions</h6>
        <a href="index.php?action=create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nouvelle Mission
        </a>
    </div>
    <?php if (empty($missions)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3" style="color: var(--light);"></i>
            <h5 style="color: var(--primary);">Aucune mission</h5>
            <p style="color: var(--light);">Commencez par ajouter votre premiere mission.</p>
            <a href="index.php?action=create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Ajouter une mission
            </a>
        </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
                <tr class="text-white">
                    <th>#</th>
                    <th>Titre</th>
                    <th>Budget</th>
                    <th>Date debut</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Competences</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($missions as $m): ?>
                <tr>
                    <td><strong>#<?= $m['id'] ?></strong></td>
                    <td><strong><?= htmlspecialchars($m['titre']) ?></strong></td>
                    <td><span style="color: var(--primary); font-weight: 700;"><?= number_format($m['budget'], 0, ',', ' ') ?> EUR</span></td>
                    <td><?= date('d/m/Y', strtotime($m['date_debut'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($m['date_fin'])) ?></td>
                    <td>
                        <span class="badge bg-<?= $m['statut'] === 'ouverte' ? 'success' : ($m['statut'] === 'en_cours' ? 'warning' : 'secondary') ?>">
                            <?= ucfirst(str_replace('_', ' ', $m['statut'])) ?>
                        </span>
                    </td>
                    <td><small style="color: var(--light);"><?= htmlspecialchars($m['competences']) ?></small></td>
                    <td>
                        <a href="index.php?action=edit&id=<?= $m['id'] ?>" class="btn btn-sm btn-primary" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="index.php?action=candidatures&mission_id=<?= $m['id'] ?>" class="btn btn-sm btn-info" title="Candidatures">
                            <i class="fas fa-user-check"></i>
                        </a>
                        <a href="index.php?action=delete&id=<?= $m['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Supprimer cette mission ?')"
                           title="Supprimer">
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
<?php
$content = ob_get_clean();
require_once 'layout.php';
?>