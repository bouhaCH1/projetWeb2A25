<?php
$pageTitle = 'list';
require_once __DIR__ . '/../layout/dashboard_header.php';
?>

<style>
    .mission-list-container {
        background: rgba(18, 22, 31, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        padding: 30px;
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
        transform: scale(1.01);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
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
    }

    /* Action Buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        filter: brightness(1.15);
    }

    .btn-action-edit {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-action-candidates {
        background: rgba(6, 182, 212, 0.15);
        color: #22d3ee;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Status Badges */
    .status-badge {
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-ouverte {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-en-cours {
        background: rgba(234, 179, 8, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .status-terminee {
        background: rgba(6, 182, 212, 0.15);
        color: #22d3ee;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }

    .empty-state-forge {
        padding: 60px 0;
        text-align: center;
    }

    .empty-state-icon-forge {
        background: linear-gradient(135deg, #ff6b35, #e63946);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }
</style>

<div class="mission-list-container fade-in">
    <header class="mb-5">
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; background: var(--accent-gradient); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 20px; box-shadow: 0 10px 20px rgba(230, 57, 70, 0.3);">
                        <i class="fas fa-layer-group text-white" style="font-size: 1.4rem;"></i>
                    </div>
                    <div>
                        <h1 class="h3 text-white fw-900 mb-0">Gestion des Missions</h1>
                        <p class="text-muted mb-0 small">Pilotez et suivez l'ensemble de vos projets.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3 justify-content-md-end align-items-center">
                    <!-- Styled Sort Dropdown -->
                    <form method="GET" action="index.php" class="d-flex align-items-center" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0 15px;">
                        <input type="hidden" name="action" value="admin_missions">
                        <i class="fas fa-sort-amount-down text-primary me-2"></i>
                        <select name="sort" onchange="this.form.submit()" 
                                style="background: transparent; border: none; color: #fff; padding: 12px 10px; outline: none; cursor: pointer; font-weight: 700; font-size: 0.85rem;">
                            <option value="date_desc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'date_desc') ? 'selected' : '' ?>>Plus récents</option>
                            <option value="title_asc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'title_asc') ? 'selected' : '' ?>>Titre (A-Z)</option>
                            <option value="title_desc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'title_desc') ? 'selected' : '' ?>>Titre (Z-A)</option>
                        </select>
                    </form>

                    <a href="index.php?action=admin_mission_create" class="btn btn-primary px-4 py-3 fw-800 rounded-4 pulse-on-hover shadow-lg">
                        <i class="fas fa-plus me-2"></i> AJOUTER
                    </a>
                </div>
            </div>
        </div>
    </header>

    <?php if (empty($missions)): ?>
        <div class="empty-state-forge slide-in-up">
            <div class="empty-state-icon-forge">
                <i class="fas fa-ghost fa-5x"></i>
            </div>
            <h2 class="h5 text-white mb-3">Le vide sidéral...</h2>
            <p class="text-muted mb-4">Aucune mission n'a été forgée pour le moment.</p>
            <a href="index.php?action=admin_mission_create" class="btn btn-outline-primary px-4">
                Lancer une expédition
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-premium mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Détails de la Mission</th>
                        <th>Budget</th>
                        <th>Statut</th>
                        <th>Période</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($missions as $m): ?>
                    <tr>
                        <td>
                            <span class="id-badge">#<?= htmlspecialchars($m['id']) ?></span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-white mb-1"><?= htmlspecialchars($m['titre']) ?></strong>
                                <div class="d-flex gap-2 align-items-center">
                                    <small class="badge bg-dark text-muted fw-normal" style="font-size: 0.65rem;">
                                        <?= htmlspecialchars($m['categorie'] ?? 'Sans catégorie') ?>
                                    </small>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="fas fa-code me-1"></i>
                                        <?= htmlspecialchars(substr($m['competences'], 0, 30)) ?><?= strlen($m['competences']) > 30 ? '...' : '' ?>
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-primary fw-800">
                                <?= number_format($m['budget'], 0, ',', ' ') ?> <small>EUR</small>
                            </div>
                        </td>
                        <td>
                            <?php 
                            $badgeClass = 'status-ouverte';
                            $statusText = 'Inconnu';
                            $statusIcon = 'fas fa-circle';
                            switch($m['statut']) {
                                case 'ouverte': $badgeClass = 'status-ouverte'; $statusText = 'Ouverte'; $statusIcon = 'fas fa-door-open'; break;
                                case 'en_cours': $badgeClass = 'status-en-cours'; $statusText = 'En cours'; $statusIcon = 'fas fa-spinner'; break;
                                case 'terminee': $badgeClass = 'status-terminee'; $statusText = 'Terminée'; $statusIcon = 'fas fa-check-double'; break;
                            }
                            ?>
                            <span class="status-badge <?= $badgeClass ?>">
                                <i class="<?= $statusIcon ?>"></i> <?= $statusText ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column text-muted" style="font-size: 0.8rem;">
                                <span><i class="fas fa-calendar-day me-1"></i> <?= date('d/m/Y', strtotime($m['date_debut'])) ?></span>
                                <span><i class="fas fa-hourglass-end me-1"></i> <?= date('d/m/Y', strtotime($m['date_fin'])) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                <a href="index.php?action=admin_mission_edit&id=<?= $m['id'] ?>" class="btn-action btn-action-edit" title="Modifier">
                                    <i class="fas fa-pen"></i> Modifier
                                </a>
                                <a href="index.php?action=admin_mission_candidatures&mission_id=<?= $m['id'] ?>" class="btn-action btn-action-candidates" title="Candidatures">
                                    <i class="fas fa-users"></i> Candidats
                                </a>
                                <form method="POST" action="index.php?action=admin_mission_delete&id=<?= $m['id'] ?>" onsubmit="return confirm('Supprimer définitivement cette mission ?');" style="display:inline;">
                                    <button type="submit" class="btn-action btn-action-delete">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
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

require_once __DIR__ . '/../layout/dashboard_footer.php';
?>
