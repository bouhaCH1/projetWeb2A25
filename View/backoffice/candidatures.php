<?php
$activePage = 'candidatures';
$pageTitle = 'Candidatures';
$pageIcon = 'user-check';

ob_start();
?>

<style>
    .candidatures-container {
        background: rgba(18, 22, 31, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .filter-forge {
        background: rgba(255, 255, 255, 0.03);
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table-premium {
        border-collapse: separate;
        border-spacing: 0 10px;
        color: #cfd6e6;
    }

    .table-premium thead th {
        background: transparent;
        border: none;
        color: #ff936d;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 15px 20px;
    }

    .table-premium tbody tr {
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.3s ease;
    }

    .table-premium tbody tr:hover {
        background: rgba(255, 107, 53, 0.08);
        transform: scale(1.005);
    }

    .table-premium td {
        border: none;
        padding: 20px;
        vertical-align: middle;
    }

    .table-premium td:first-child { border-radius: 12px 0 0 12px; }
    .table-premium td:last-child { border-radius: 0 12px 12px 0; }

    .id-badge {
        background: rgba(255, 107, 53, 0.1);
        color: #ff936d;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .premium-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-action-round {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-action-round:hover {
        transform: scale(1.15);
    }

    .motivation-text {
        font-size: 0.85rem;
        color: #9ca7bd;
        line-height: 1.5;
        max-width: 250px;
    }

    .candidate-avatar {
        width: 40px;
        height: 40px;
        background: var(--accent-gradient);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        margin-right: 12px;
    }
</style>

<div class="candidatures-container fade-in">
    <header class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 text-white fw-800 mb-1">
                <i class="fas fa-user-check text-primary me-2"></i>
                Gestion des Candidatures
            </h1>
            <p class="text-muted mb-0">Analysez les profils et sélectionnez les meilleurs talents.</p>
        </div>
        <a href="index.php?action=index" class="btn btn-outline-light px-4 py-2 fw-bold">
            <i class="fas fa-briefcase me-2 text-primary"></i> Voir les missions
        </a>
    </header>

    <div class="filter-forge">
        <form method="GET" action="index.php" class="row g-3 align-items-center">
            <input type="hidden" name="action" value="candidatures">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-0 text-primary">
                        <i class="fas fa-filter"></i>
                    </span>
                    <select name="mission_id" class="form-select bg-dark border-0 text-white" id="mission-filter">
                        <option value="">Toutes les missions</option>
                        <?php foreach ($missions as $m): ?>
                            <option value="<?= (int)$m['id'] ?>" <?= ($selectedMissionId === (int)$m['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['titre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                <a href="index.php?action=candidatures" class="btn btn-dark border-0" title="Réinitialiser">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <?php if (empty($candidatures)): ?>
        <div class="text-center py-5">
            <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
            <h3 class="h5 text-white">Aucune candidature</h3>
            <p class="text-muted">Il n'y a pas encore de postulants pour ces critères.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-premium mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Candidat</th>
                        <th>Mission</th>
                        <th>Contact</th>
                        <th>Motivation</th>
                        <th>Statut</th>
                        <th class="text-center">Décision</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $c): ?>
                    <tr>
                        <td>
                            <span class="id-badge">#<?= (int)$c['id'] ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="candidate-avatar">
                                    <?= strtoupper(substr($c['prenom'], 0, 1) . substr($c['nom'], 0, 1)) ?>
                                </div>
                                <div class="d-flex flex-column">
                                    <strong class="text-white"><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></strong>
                                    <small class="text-muted"><i class="fas fa-phone me-1" style="font-size: 0.7rem;"></i> <?= htmlspecialchars($c['telephone']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-white small fw-bold">
                                <?= htmlspecialchars($c['mission_titre']) ?>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($c['email']) ?>" class="text-primary text-decoration-none small">
                                <i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($c['email']) ?>
                            </a>
                        </td>
                        <td>
                            <div class="motivation-text">
                                <?= nl2br(htmlspecialchars(substr($c['motivation'], 0, 80))) ?>...
                                <?php if (strlen($c['motivation']) > 80): ?>
                                    <button class="btn btn-link btn-sm text-primary p-0 border-0" 
                                            onclick="alert('<?= addslashes($c['motivation']) ?>')"
                                            style="font-size: 0.75rem;">Voir plus</button>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <?php 
                                $badgeClass = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25';
                                $statutText = 'En attente';
                                $statusIcon = 'fas fa-clock';
                                if (isset($c['statut'])) {
                                    if ($c['statut'] === 'acceptee') { 
                                        $badgeClass = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; 
                                        $statutText = 'Acceptée'; 
                                        $statusIcon = 'fas fa-check-circle';
                                    }
                                    if ($c['statut'] === 'refusee') { 
                                        $badgeClass = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25'; 
                                        $statutText = 'Refusée'; 
                                        $statusIcon = 'fas fa-times-circle';
                                    }
                                }
                            ?>
                            <span class="premium-badge <?= $badgeClass ?>">
                                <i class="<?= $statusIcon ?>"></i> <?= $statutText ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=acceptee" 
                                   class="btn-action-round bg-success bg-opacity-20 text-success" title="Accepter">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=refusee" 
                                   class="btn-action-round bg-danger bg-opacity-20 text-danger" title="Refuser">
                                    <i class="fas fa-times"></i>
                                </a>
                                <a href="index.php?action=delete_candidature&id=<?= $c['id'] ?>" 
                                   onclick="return confirm('Supprimer cette candidature ?');"
                                   class="btn-action-round bg-dark text-muted" title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <footer class="mt-4 text-center">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                <?= count($candidatures) ?> candidature<?= count($candidatures) > 1 ? 's' : '' ?> trouvée<?= count($candidatures) > 1 ? 's' : '' ?>
                <?php if ($selectedMissionId): ?>
                    pour la mission sélectionnée
                <?php endif; ?>
            </small>
        </footer>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
