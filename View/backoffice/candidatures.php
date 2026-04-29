<?php
$activePage = 'candidatures';
$pageTitle = 'Candidatures';
$pageIcon = 'user-check';

ob_start();
?>

<div class="bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0"><i class="fas fa-user-check me-2"></i>Liste des Candidatures</h6>
        <a href="index.php?action=index" class="btn btn-primary btn-sm">
            <i class="fas fa-briefcase me-1"></i> Voir les missions
        </a>
    </div>

    <div class="border-bottom pb-3 mb-3">
        <form method="GET" action="index.php" class="row g-2 align-items-center">
            <input type="hidden" name="action" value="candidatures">
            <div class="col-md-8">
                <select name="mission_id" class="form-select bg-dark border-0">
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
                <a href="index.php?action=candidatures" class="btn btn-outline-light btn-sm">
                    Reinitialiser
                </a>
            </div>
        </form>
    </div>

    <?php if (empty($candidatures)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3" style="color: var(--light);"></i>
            <h5 style="color: var(--primary);">Aucune candidature</h5>
            <p style="color: var(--light);">Il n'y a pas encore de candidatures pour vos missions.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th>#</th>
                        <th>Mission</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th style="width:20%">Motivation</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $c): ?>
                        <tr>
                            <td><strong>#<?= (int)$c['id'] ?></strong></td>
                            <td><strong><?= htmlspecialchars($c['mission_titre']) ?></strong></td>
                            <td><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="color: var(--primary); text-decoration: none;">
                                    <?= htmlspecialchars($c['email']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($c['telephone']) ?></td>
                            <td>
                                <small style="color: var(--light);"><?= nl2br(htmlspecialchars(substr($c['motivation'], 0, 100))) ?>...</small>
                            </td>
                            <td>
                                <?php 
                                    $badgeClass = 'bg-secondary';
                                    $statutText = 'En attente';
                                    if (isset($c['statut'])) {
                                        if ($c['statut'] === 'acceptee') { $badgeClass = 'bg-success'; $statutText = 'Acceptee'; }
                                        if ($c['statut'] === 'refusee') { $badgeClass = 'bg-danger'; $statutText = 'Refusee'; }
                                    }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $statutText ?></span>
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <small style="color: var(--light);" class="d-block mb-2"><i class="fas fa-clock me-1"></i><?= !empty($c['created_at']) ? date('d/m/Y H:i', strtotime($c['created_at'])) : '-' ?></small>
                                    <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=acceptee" class="btn btn-sm btn-success me-1 <?= (isset($c['statut']) && $c['statut'] === 'acceptee') ? 'active' : '' ?>" title="Accepter"><i class="fas fa-check"></i></a>
                                    <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=refusee" class="btn btn-sm btn-danger me-1 <?= (isset($c['statut']) && $c['statut'] === 'refusee') ? 'active' : '' ?>" title="Refuser"><i class="fas fa-times"></i></a>
                                    <a href="index.php?action=delete_candidature&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-light" title="Supprimer" onclick="return confirm('Etes-vous sur de vouloir supprimer cette candidature ?');"><i class="fas fa-trash"></i></a>
                                </div>
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
