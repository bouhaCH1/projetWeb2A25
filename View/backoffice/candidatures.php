<?php
$activePage = 'candidatures';
$pageTitle = 'Candidatures';
$pageIcon = 'user-check';

ob_start();
?>

<section class="bg-secondary rounded p-4 fade-in">
    <header class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h6 mb-0 d-flex align-items-center">
            <i class="fas fa-user-check me-2 text-primary"></i>
            <span>Liste des Candidatures</span>
        </h1>
        <a href="index.php?action=index" class="btn btn-primary btn-sm pulse-on-hover" title="Voir toutes les missions">
            <i class="fas fa-briefcase me-1"></i> 
            <span>Voir les missions</span>
        </a>
    </header>

    <div class="filter-section border-bottom pb-3 mb-3">
        <form method="GET" action="index.php" class="row g-2 align-items-center">
            <input type="hidden" name="action" value="candidatures">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-0">
                        <i class="fas fa-filter text-primary"></i>
                    </span>
                    <select name="mission_id" class="form-select bg-dark border-0" id="mission-filter">
                        <option value="">Toutes les missions</option>
                        <?php foreach ($missions as $m): ?>
                            <option value="<?= (int)$m['id'] ?>" <?= ($selectedMissionId === (int)$m['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['titre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter me-1"></i> 
                    <span>Filtrer</span>
                </button>
                <a href="index.php?action=candidatures" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-redo me-1"></i> 
                    <span>Réinitialiser</span>
                </a>
            </div>
        </form>
    </div>

    <?php if (empty($candidatures)): ?>
        <article class="text-center py-5 empty-state">
            <div class="empty-state-icon mb-3">
                <i class="fas fa-user-slash fa-4x text-light"></i>
            </div>
            <h2 class="h5 text-primary mb-3">Aucune candidature</h2>
            <p class="text-light mb-4">Il n'y a pas encore de candidatures pour vos missions.</p>
            <a href="index.php?action=index" class="btn btn-primary btn-sm fade-in">
                <i class="fas fa-briefcase me-1"></i> 
                <span>Voir les missions</span>
            </a>
        </article>
    <?php else: ?>
        <div class="table-responsive slide-in-left">
            <table class="table text-start align-middle table-bordered table-hover mb-0" role="table">
                <thead>
                    <tr class="text-white">
                        <th scope="col">#</th>
                        <th scope="col">Mission</th>
                        <th scope="col">Candidat</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col" style="width:20%">Motivation</th>
                        <th scope="col">Statut</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $c): ?>
                    <tr class="table-row-hover">
                        <td scope="row">
                            <strong class="text-primary">#<?= (int)$c['id'] ?></strong>
                        </td>
                        <td>
                            <strong class="mission-title"><?= htmlspecialchars($c['mission_titre']) ?></strong>
                        </td>
                        <td>
                            <div class="candidate-info">
                                <strong><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></strong>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($c['email']) ?>" 
                               class="text-primary text-decoration-none" 
                               title="Envoyer un email à <?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?>">
                                <i class="fas fa-envelope me-1"></i>
                                <?= htmlspecialchars($c['email']) ?>
                            </a>
                        </td>
                        <td>
                            <a href="tel:<?= htmlspecialchars($c['telephone']) ?>" 
                               class="text-light text-decoration-none"
                               title="Appeler <?= htmlspecialchars($c['prenom']) ?>">
                                <i class="fas fa-phone me-1"></i>
                                <?= htmlspecialchars($c['telephone']) ?>
                            </a>
                        </td>
                        <td>
                            <div class="motivation-preview">
                                <small class="text-light d-block">
                                    <?= nl2br(htmlspecialchars(substr($c['motivation'], 0, 100))) ?>...
                                </small>
                                <?php if (strlen($c['motivation']) > 100): ?>
                                    <button class="btn btn-link btn-sm text-primary p-0" 
                                            onclick="this.parentElement.innerHTML = '<?= nl2br(htmlspecialchars($c['motivation'])) ?>'"
                                            title="Voir la motivation complète">
                                        <i class="fas fa-expand-alt"></i> Voir plus
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <?php 
                                $badgeClass = 'bg-secondary';
                                $statutText = 'En attente';
                                $statusIcon = 'fas fa-clock';
                                if (isset($c['statut'])) {
                                    if ($c['statut'] === 'acceptee') { 
                                        $badgeClass = 'bg-success'; 
                                        $statutText = 'Acceptée'; 
                                        $statusIcon = 'fas fa-check-circle';
                                    }
                                    if ($c['statut'] === 'refusee') { 
                                        $badgeClass = 'bg-danger'; 
                                        $statutText = 'Refusée'; 
                                        $statusIcon = 'fas fa-times-circle';
                                    }
                                }
                                ?>
                            <span class="badge <?= $badgeClass ?>" title="Statut: <?= $statutText ?>">
                                <i class="<?= $statusIcon ?> me-1"></i>
                                <?= $statutText ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons d-flex flex-column gap-1" role="group">
                                <div class="text-nowrap">
                                    <small class="text-light d-block mb-2">
                                        <i class="fas fa-clock me-1"></i>
                                        <?= !empty($c['created_at']) ? date('d/m/Y H:i', strtotime($c['created_at'])) : '-' ?>
                                    </small>
                                </div>
                                <div class="d-flex gap-1 justify-content-center">
                                    <form method="POST" action="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=acceptee" 
                                          style="display: inline;">
                                        <button type="submit" 
                                                class="btn btn-sm btn-success me-1 <?= (isset($c['statut']) && $c['statut'] === 'acceptee') ? 'active' : '' ?>" 
                                                title="Accepter la candidature de <?= htmlspecialchars($c['prenom']) ?>"
                                                aria-label="Accepter">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=refusee" 
                                          style="display: inline;">
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger me-1 <?= (isset($c['statut']) && $c['statut'] === 'refusee') ? 'active' : '' ?>" 
                                                title="Refuser la candidature de <?= htmlspecialchars($c['prenom']) ?>"
                                                aria-label="Refuser">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="index.php?action=delete_candidature&id=<?= $c['id'] ?>" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?');"
                                          style="display: inline;">
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-light" 
                                                title="Supprimer la candidature de <?= htmlspecialchars($c['prenom']) ?>"
                                                aria-label="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <footer class="mt-3 text-center">
            <small class="text-light">
                <i class="fas fa-info-circle me-1"></i>
                <?= count($candidatures) ?> candidature<?= count($candidatures) > 1 ? 's' : '' ?> trouvée<?= count($candidatures) > 1 ? 's' : '' ?>
                <?php if ($selectedMissionId): ?>
                    pour la mission sélectionnée
                <?php endif; ?>
            </small>
        </footer>
    <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
