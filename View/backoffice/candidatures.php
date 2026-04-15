<?php
$activePage = 'candidatures';
$pageTitle = 'Candidatures';
$pageIcon = 'user-check';

ob_start();
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-user-check me-2"></i>Liste des candidatures</span>
        <a href="index.php?action=index" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-briefcase me-1"></i> Voir les missions
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="index.php" class="row g-2 align-items-center">
            <input type="hidden" name="action" value="candidatures">
            <div class="col-md-8">
                <select name="mission_id" class="form-select">
                    <option value="">Toutes les missions</option>
                    <?php foreach ($missions as $m): ?>
                        <option value="<?= (int)$m['id'] ?>" <?= ($selectedMissionId === (int)$m['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['titre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter me-1"></i> Filtrer
                </button>
                <a href="index.php?action=candidatures" class="btn btn-outline-secondary btn-sm">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <?php if (empty($candidatures)): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Aucune candidature pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th>#</th>
                            <th>Mission</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th style="width:20%">Motivation</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($candidatures as $c): ?>
                            <tr>
                                <td><?= (int)$c['id'] ?></td>
                                <td><strong><?= htmlspecialchars($c['mission_titre']) ?></strong></td>
                                <td><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($c['email']) ?>">
                                        <?= htmlspecialchars($c['email']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($c['telephone']) ?></td>
                                <td>
                                    <small><?= nl2br(htmlspecialchars($c['motivation'])) ?></small>
                                </td>
                                <td>
                                    <?php 
                                        $badgeClass = 'bg-secondary';
                                        $statutText = 'En attente';
                                        if (isset($c['statut'])) {
                                            if ($c['statut'] === 'acceptee') { $badgeClass = 'bg-success'; $statutText = 'Acceptée'; }
                                            if ($c['statut'] === 'refusee') { $badgeClass = 'bg-danger'; $statutText = 'Refusée'; }
                                        }
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $statutText ?></span>
                                </td>
                                <td>
                                    <div class="text-nowrap mb-1">
                                        <small class="text-muted d-block mb-2"><?= !empty($c['created_at']) ? date('d/m/Y H:i', strtotime($c['created_at'])) : '-' ?></small>
                                        <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=acceptee" class="btn btn-sm <?= (isset($c['statut']) && $c['statut'] === 'acceptee') ? 'btn-success' : 'btn-outline-success' ?>" title="Accepter"><i class="fas fa-check"></i></a>
                                        <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=refusee" class="btn btn-sm <?= (isset($c['statut']) && $c['statut'] === 'refusee') ? 'btn-danger' : 'btn-outline-danger' ?>" title="Refuser"><i class="fas fa-times"></i></a>
                                        <a href="index.php?action=delete_candidature&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger ms-1" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?');"><i class="fas fa-trash"></i></a>
                                    </div>
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
