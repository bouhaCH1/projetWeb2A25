<?php
$activePage = 'list';
$pageTitle  = 'Gestion des Missions';
$pageIcon   = 'list';

ob_start();
?>

<section class="bg-secondary rounded p-4 fade-in">
    <header class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h6 mb-0 d-flex align-items-center">
            <i class="fas fa-briefcase me-2 text-primary"></i>
            <span>Liste des Missions</span>
        </h1>
        <a href="index.php?action=create" class="btn btn-primary btn-sm pulse-on-hover" title="Créer une nouvelle mission">
            <i class="fas fa-plus me-1"></i> 
            <span>Nouvelle Mission</span>
        </a>
    </header>

    <?php if (empty($missions)): ?>
        <article class="text-center py-5 empty-state">
            <div class="empty-state-icon mb-3">
                <i class="fas fa-inbox fa-4x text-light"></i>
            </div>
            <h2 class="h5 text-primary mb-3">Aucune mission</h2>
            <p class="text-light mb-4">Commencez par ajouter votre première mission.</p>
            <a href="index.php?action=create" class="btn btn-primary btn-sm fade-in">
                <i class="fas fa-plus me-1"></i> 
                <span>Ajouter une mission</span>
            </a>
        </article>
    <?php else: ?>
        <div class="table-responsive slide-in-left">
            <table class="table text-start align-middle table-bordered table-hover mb-0" role="table">
                <thead>
                    <tr class="text-white">
                        <th scope="col">#</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Date début</th>
                        <th scope="col">Date fin</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Compétences</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($missions as $m): ?>
                    <tr class="table-row-hover">
                        <td scope="row">
                            <strong class="text-primary">#<?= htmlspecialchars($m['id']) ?></strong>
                        </td>
                        <td>
                            <strong class="mission-title"><?= htmlspecialchars($m['titre']) ?></strong>
                        </td>
                        <td>
                            <span class="budget-amount text-primary fw-bold">
                                <?= number_format($m['budget'], 0, ',', ' ') ?> EUR
                            </span>
                        </td>
                        <td>
                            <time datetime="<?= $m['date_debut'] ?>">
                                <?= date('d/m/Y', strtotime($m['date_debut'])) ?>
                            </time>
                        </td>
                        <td>
                            <time datetime="<?= $m['date_fin'] ?>">
                                <?= date('d/m/Y', strtotime($m['date_fin'])) ?>
                            </time>
                        </td>
                        <td>
                            <?php 
                            $badgeClass = 'bg-secondary';
                            $statusText = ucfirst(str_replace('_', ' ', $m['statut']));
                            switch($m['statut']) {
                                case 'ouverte': 
                                    $badgeClass = 'bg-success'; 
                                    break;
                                case 'en_cours': 
                                    $badgeClass = 'bg-warning'; 
                                    break;
                                case 'terminee': 
                                    $badgeClass = 'bg-secondary'; 
                                    break;
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>" title="Statut: <?= $statusText ?>">
                                <?= $statusText ?>
                            </span>
                        </td>
                        <td>
                            <small class="text-light d-block"><?= htmlspecialchars($m['competences']) ?></small>
                        </td>
                        <td>
                            <div class="action-buttons d-flex gap-1 justify-content-center" role="group">
                                <a href="index.php?action=edit&id=<?= $m['id'] ?>" 
                                   class="btn btn-sm btn-primary" 
                                   title="Modifier la mission #<?= $m['id'] ?>"
                                   aria-label="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?action=candidatures&mission_id=<?= $m['id'] ?>" 
                                   class="btn btn-sm btn-info" 
                                   title="Voir les candidatures pour <?= htmlspecialchars($m['titre']) ?>"
                                   aria-label="Candidatures">
                                    <i class="fas fa-user-check"></i>
                                </a>
                                <form method="POST" action="index.php?action=delete&id=<?= $m['id'] ?>" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?');"
                                      style="display: inline;">
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Supprimer la mission #<?= $m['id'] ?>"
                                            aria-label="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
                <?= count($missions) ?> mission<?= count($missions) > 1 ? 's' : '' ?> trouvée<?= count($missions) > 1 ? 's' : '' ?>
            </small>
        </footer>
    <?php endif; ?>
</section>
<?php
$content = ob_get_clean();
require_once 'layout.php';
?>