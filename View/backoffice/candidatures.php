<?php
$activePage = 'candidatures';
$pageTitle = 'Candidatures';
$pageIcon = 'user-check';

ob_start();
?>

<style>
    /* Main Container */
    .candidatures-container {
        background: rgba(18, 22, 31, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        padding: 30px;
    }

    /* Filters */
    .filter-forge {
        background: rgba(255, 255, 255, 0.03);
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Table Design */
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
        letter-spacing: 1.5px;
        padding: 15px 20px;
    }

    .table-premium tbody tr {
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .table-premium tbody tr:hover {
        background: rgba(255, 107, 53, 0.12);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .table-premium td {
        border: none;
        padding: 20px;
        vertical-align: middle;
    }

    .table-premium td:first-child { border-radius: 12px 0 0 12px; }
    .table-premium td:last-child { border-radius: 0 12px 12px 0; }

    /* Badges & Avatars */
    .id-badge {
        background: rgba(255, 107, 53, 0.1);
        color: #ff936d;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .candidate-avatar {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #ff6b35, #e63946);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        margin-right: 12px;
        box-shadow: 0 4px 10px rgba(255, 107, 53, 0.3);
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
        gap: 6px;
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

    .btn-action-view {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-action-accept {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .btn-action-reject {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-action-delete {
        background: rgba(107, 114, 128, 0.15);
        color: #9ca3af;
        border: 1px solid rgba(107, 114, 128, 0.3);
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

    .status-pending {
        background: rgba(234, 179, 8, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .status-accepted {
        background: rgba(34, 197, 94, 0.15);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Action Buttons */
    .btn-action-round {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-action-round:hover {
        transform: scale(1.1) translateY(-2px);
        filter: brightness(1.2);
    }

    /* Modal Forge Styles */
    .modal-forge .modal-content {
        background: #12161f;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
    }

    .modal-forge .modal-header {
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 20px 30px;
    }

    .modal-forge .modal-body {
        padding: 30px;
    }

    .info-card-forge {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        transition: all 0.3s ease;
    }

    .info-card-forge:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 107, 53, 0.2);
    }

    .label-forge {
        color: #ff936d;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: block;
        margin-bottom: 8px;
    }

    .value-forge {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .motivation-box {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        color: #cfd6e6;
        font-size: 0.9rem;
        line-height: 1.6;
        max-height: 250px;
        overflow-y: auto;
        white-space: pre-wrap;
    }

    .btn-forge-close {
        background: #fff;
        color: #12161f;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-forge-close:hover {
        background: #f0f0f0;
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    /* Matching Score Styles */
    .score-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        color: #fff;
        position: relative;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .score-circle::after {
        content: '';
        position: absolute;
        inset: 3px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.2);
    }

    .score-excellent { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .score-good { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .score-average { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .score-low { background: linear-gradient(135deg, #ef4444, #dc2626); }

    .match-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-block;
        margin-top: 4px;
    }

    .match-badge-excellent { background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
    .match-badge-good { background: rgba(59,130,246,0.15); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3); }
    .match-badge-average { background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
    .match-badge-low { background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }

    /* Top 3 Candidates */
    .top-candidates-section {
        margin-bottom: 35px;
    }

    .top-candidate-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .top-candidate-card:hover {
        transform: translateY(-4px);
        border-color: rgba(255,107,53,0.3);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }

    .top-candidate-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ff6b35, #e63946);
    }

    .top-rank {
        position: absolute;
        top: 10px;
        right: 15px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff6b35, #e63946);
        color: #fff;
        font-weight: 800;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .top-score-bar {
        height: 6px;
        border-radius: 10px;
        background: rgba(255,255,255,0.05);
        overflow: hidden;
        margin-top: 12px;
    }

    .top-score-fill {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(90deg, #22c55e, #4ade80);
        transition: width 0.8s ease;
    }
</style>

<div class="candidatures-container fade-in">
    <!-- Header Section -->
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

    <!-- Modern Forge Filter Bar -->
    <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 25px; margin-bottom: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <form method="GET" action="index.php" class="row g-4 align-items-center">
            <input type="hidden" name="action" value="candidatures">
            
            <!-- Mission Filter -->
            <div class="col-lg-5">
                <div class="d-flex align-items-center" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0 15px;">
                    <i class="fas fa-briefcase text-primary me-2"></i>
                    <select name="mission_id" id="mission-filter" 
                            style="background: transparent; border: none; color: #fff; padding: 12px 10px; width: 100%; outline: none; cursor: pointer; font-weight: 600;">
                        <option value="" style="background: #12161f;">Toutes les missions</option>
                        <?php foreach ($missions as $m): ?>
                            <option value="<?= (int)$m['id'] ?>" style="background: #12161f;" <?= ($selectedMissionId === (int)$m['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['titre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Sort Toggle -->
            <div class="col-lg-4">
                <div class="d-flex align-items-center" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 0 15px;">
                    <i class="fas fa-sort-alpha-down text-primary me-2"></i>
                    <select name="sort" onchange="this.form.submit()" 
                            style="background: transparent; border: none; color: #fff; padding: 12px 10px; width: 100%; outline: none; cursor: pointer; font-weight: 600;">
                        <option value="date_desc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'date_desc') ? 'selected' : '' ?>>Plus récents</option>
                        <option value="name_asc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'name_asc') ? 'selected' : '' ?>>Prénom (A-Z)</option>
                        <option value="name_desc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'name_desc') ? 'selected' : '' ?>>Prénom (Z-A)</option>
                        <option value="score_desc" style="background: #12161f;" <?= (($_GET['sort'] ?? '') === 'score_desc') ? 'selected' : '' ?>>Meilleur Match</option>
                    </select>
                </div>
            </div>

            <!-- Actions -->
            <div class="col-lg-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-800 rounded-3 shadow-sm">
                        <i class="fas fa-filter me-2"></i> FILTRER
                    </button>
                    <?php if(!empty($_GET['mission_id']) || !empty($_GET['sort'])): ?>
                        <a href="index.php?action=candidatures" class="btn btn-dark px-3 rounded-3 d-flex align-items-center justify-content-center" title="Reset">
                            <i class="fas fa-redo"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Top 3 Candidates Section -->
    <?php if (!empty($topCandidates)): ?>
    <div class="top-candidates-section">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-crown text-warning me-2"></i>
            <h5 class="text-white fw-800 mb-0">Top Candidats Recommandés</h5>
        </div>
        <div class="row g-4">
            <?php $rank = 1; foreach ($topCandidates as $top): ?>
            <div class="col-md-4">
                <div class="top-candidate-card">
                    <div class="top-rank">#<?= $rank++ ?></div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="candidate-avatar" style="width: 46px; height: 46px; font-size: 0.9rem;">
                            <?= strtoupper(substr($top['prenom'], 0, 1) . substr($top['nom'], 0, 1)) ?>
                        </div>
                        <div class="ms-3">
                            <div class="text-white fw-700"><?= htmlspecialchars($top['prenom'] . ' ' . $top['nom']) ?></div>
                            <div class="text-muted small"><?= htmlspecialchars($top['mission_titre']) ?></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="match-badge match-badge-excellent"><i class="fas fa-star me-1"></i> Excellent Match</span>
                        <span class="text-white fw-800"><?= (int)$top['matching_score'] ?>%</span>
                    </div>
                    <div class="top-score-bar">
                        <div class="top-score-fill" style="width: <?= (int)$top['matching_score'] ?>%"></div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn-action btn-action-view w-100" onclick="showCandidateDetails(<?= htmlspecialchars(json_encode($top)) ?>)">
                            <i class="fas fa-eye"></i> Voir
                        </button>
                        <a href="index.php?action=update_candidature_statut&id=<?= $top['id'] ?>&statut=acceptee" class="btn-action btn-action-accept w-100 text-center text-decoration-none">
                            <i class="fas fa-check"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Data Table Section -->
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
                        <th class="text-center">Matching</th>
                        <th>Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $c): ?>
                        <tr>
                            <td><span class="id-badge">#<?= (int)$c['id'] ?></span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="candidate-avatar">
                                        <?= strtoupper(substr($c['prenom'], 0, 1) . substr($c['nom'], 0, 1)) ?>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <strong class="text-white"><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></strong>
                                        <small class="text-muted"><?= htmlspecialchars($c['telephone']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-white small fw-bold">
                                    <?= htmlspecialchars($c['mission_titre']) ?>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($c['email']) ?>" class="text-primary text-decoration-none small d-block mb-1">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </a>
                                <a href="tel:<?= htmlspecialchars($c['telephone']) ?>" class="text-muted text-decoration-none small">
                                    <i class="fas fa-phone me-1"></i> Contact
                                </a>
                            </td>
                            <td class="text-center">
                                <?php
                                    $score = (int)($c['matching_score'] ?? 0);
                                    $scoreClass = $score >= 80 ? 'score-excellent' : ($score >= 60 ? 'score-good' : ($score >= 40 ? 'score-average' : 'score-low'));
                                    $badgeClass = $score >= 80 ? 'match-badge-excellent' : ($score >= 60 ? 'match-badge-good' : ($score >= 40 ? 'match-badge-average' : 'match-badge-low'));
                                    $label = $score >= 80 ? 'Excellent' : ($score >= 60 ? 'Bon' : ($score >= 40 ? 'Moyen' : 'Faible'));
                                ?>
                                <div class="d-flex flex-column align-items-center">
                                    <div class="score-circle <?= $scoreClass ?>"><?= $score ?>%</div>
                                    <?php if ($score >= 80): ?>
                                        <span class="match-badge <?= $badgeClass ?>"><i class="fas fa-star me-1"></i> <?= $label ?></span>
                                    <?php else: ?>
                                        <span class="match-badge <?= $badgeClass ?>"><?= $label ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $badgeClass = 'status-pending';
                                    $statutText = 'En attente';
                                    $statusIcon = 'fas fa-clock';
                                    if (isset($c['statut'])) {
                                        if ($c['statut'] === 'acceptee') { 
                                            $badgeClass = 'status-accepted'; 
                                            $statutText = 'Acceptée'; 
                                            $statusIcon = 'fas fa-check-circle';
                                        }
                                        if ($c['statut'] === 'refusee') { 
                                            $badgeClass = 'status-rejected'; 
                                            $statutText = 'Refusée'; 
                                            $statusIcon = 'fas fa-times-circle';
                                        }
                                    }
                                ?>
                                <span class="status-badge <?= $badgeClass ?>">
                                    <i class="<?= $statusIcon ?>"></i> <?= $statutText ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center flex-wrap">
                                    <button class="btn-action btn-action-view" 
                                            title="Voir Détails"
                                            onclick="showCandidateDetails(<?= htmlspecialchars(json_encode($c)) ?>)">
                                        <i class="fas fa-eye"></i> Voir
                                    </button>
                                    <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=acceptee" 
                                       class="btn-action btn-action-accept" title="Accepter">
                                        <i class="fas fa-check"></i> Accepter
                                    </a>
                                    <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=refusee" 
                                       class="btn-action btn-action-reject" title="Refuser">
                                        <i class="fas fa-times"></i> Refuser
                                    </a>
                                    <a href="index.php?action=delete_candidature&id=<?= $c['id'] ?>" 
                                       onclick="return confirm('Supprimer cette candidature ?');"
                                       class="btn-action btn-action-delete" title="Supprimer">
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
            </small>
        </footer>
    <?php endif; ?>
</div>

<!-- Details Modal Forge -->
<div class="modal fade modal-forge" id="candidateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <div id="modalAvatar" class="candidate-avatar" style="width: 50px; height: 50px; font-size: 1.2rem;">--</div>
                    <div>
                        <h5 class="modal-title text-white fw-800 mb-0">Détails du Candidat</h5>
                        <small class="text-muted" id="modalIdLabel">Candidature #0</small>
                    </div>
                    <div id="modalStatusArea" class="ms-3"></div>
                </div>
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button type="button" id="btnEmailAccept" onclick="generateEmail('acceptation')" class="btn py-2 px-3 rounded-3 fw-700 text-white border-0 shadow-sm" style="background: linear-gradient(135deg, #00ffcc, #00ccff); font-size: 0.75rem;">
                        <i class="fas fa-envelope me-1"></i> Accepter & Email
                    </button>
                    <button type="button" id="btnEmailRefuse" onclick="generateEmail('refus')" class="btn py-2 px-3 rounded-3 fw-700 text-white border-0 shadow-sm" style="background: linear-gradient(135deg, #ff6b35, #e63946); font-size: 0.75rem;">
                        <i class="fas fa-envelope me-1"></i> Refuser & Email
                    </button>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Column Left: Basic Info -->
                    <div class="col-md-5">
                        <div class="info-card-forge mb-3">
                            <span class="label-forge">Nom Complet</span>
                            <div id="modalFullName" class="value-forge h5 mb-0">--</div>
                        </div>
                        <div class="info-card-forge mb-3">
                            <span class="label-forge">Mission Postulée</span>
                            <div id="modalMission" class="text-primary fw-700">--</div>
                        </div>
                        <div class="info-card-forge mb-3">
                            <span class="label-forge">Score de Matching</span>
                            <div class="d-flex align-items-center gap-3">
                                <div id="modalScoreCircle" class="score-circle" style="width: 46px; height: 46px; font-size: 0.8rem;">--</div>
                                <div id="modalScoreLabel" class="match-badge">--</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-card-forge">
                                    <span class="label-forge">Email Professionnel</span>
                                    <a id="modalEmail" href="#" class="value-forge text-break text-decoration-none">--</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-card-forge">
                                    <span class="label-forge">Téléphone</span>
                                    <a id="modalPhone" href="#" class="value-forge text-decoration-none">--</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column Right: Motivation & CV & Email -->
                    <div class="col-md-7">
                        <div class="info-card-forge h-100 d-flex flex-column">
                            <span class="label-forge">Lettre de Motivation</span>
                            <div id="modalMotivation" class="motivation-box flex-grow-1">--</div>
                            
                            <div id="modalCvContainer" class="mt-4 d-none">
                                <a id="modalCvLink" href="#" target="_blank" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">
                                    <i class="fas fa-file-pdf me-2"></i> Consulter le CV complet
                                </a>
                            </div>

                            <!-- Email Generated -->
                            <div id="emailGeneratedContainer" class="mt-4 d-none" style="border: 1px solid rgba(0,255,204,0.2); border-radius: 12px; padding: 15px; background: rgba(0,255,204,0.03);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <span class="label-forge" style="color: #00ffcc;"><i class="fas fa-envelope me-2"></i>Email Généré</span>
                                    <button type="button" class="btn btn-sm" onclick="copyEmail()" style="background: rgba(0,255,204,0.15); color: #00ffcc; border: none; font-size: 11px; padding: 4px 12px; border-radius: 20px;">
                                        <i class="fas fa-copy me-1"></i> Copier
                                    </button>
                                </div>
                                <div style="font-size: 13px; color: #00ffcc; font-weight: 600; margin-bottom: 8px;" id="emailGeneratedSubject">--</div>
                                <div id="emailGeneratedBody" style="font-size: 13px; color: rgba(255,255,255,0.8); line-height: 1.6; white-space: pre-wrap; max-height: 200px; overflow-y: auto;">--</div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row g-4 -->
            </div> <!-- end modal-body -->
        </div> <!-- end modal-content -->
    </div> <!-- end modal-dialog -->
</div> <!-- end modal -->

<!-- Scripts -->
<script>
    let currentCandidateId = null;

    function showCandidateDetails(data) {
        currentCandidateId = data.id;

        // Populate Data
        document.getElementById('modalIdLabel').innerText = 'Candidature #' + data.id;
        document.getElementById('modalFullName').innerText = data.prenom + ' ' + data.nom;
        document.getElementById('modalAvatar').innerText = (data.prenom[0] + data.nom[0]).toUpperCase();
        document.getElementById('modalMission').innerText = data.mission_titre;
        document.getElementById('modalEmail').innerText = data.email;
        document.getElementById('modalEmail').href = 'mailto:' + data.email;
        document.getElementById('modalPhone').innerText = data.telephone;
        document.getElementById('modalPhone').href = 'tel:' + data.telephone;
        document.getElementById('modalMotivation').innerText = data.motivation;

        // Reset email container
        document.getElementById('emailGeneratedContainer').classList.add('d-none');

        // Score handling
        const score = data.matching_score ?? 0;
        const scoreCircle = document.getElementById('modalScoreCircle');
        const scoreLabel = document.getElementById('modalScoreLabel');
        scoreCircle.innerText = score + '%';
        scoreCircle.className = 'score-circle';
        if (score >= 80) {
            scoreCircle.classList.add('score-excellent');
            scoreLabel.className = 'match-badge match-badge-excellent';
            scoreLabel.innerHTML = '<i class="fas fa-star me-1"></i> Excellent Match';
        } else if (score >= 60) {
            scoreCircle.classList.add('score-good');
            scoreLabel.className = 'match-badge match-badge-good';
            scoreLabel.innerText = 'Bon Match';
        } else if (score >= 40) {
            scoreCircle.classList.add('score-average');
            scoreLabel.className = 'match-badge match-badge-average';
            scoreLabel.innerText = 'Match Moyen';
        } else {
            scoreCircle.classList.add('score-low');
            scoreLabel.className = 'match-badge match-badge-low';
            scoreLabel.innerText = 'Faible Match';
        }

        // CV handling
        const cvContainer = document.getElementById('modalCvContainer');
        const cvLink = document.getElementById('modalCvLink');
        if (data.cv) {
            cvContainer.classList.remove('d-none');
            cvLink.href = 'uploads/' + encodeURIComponent(data.cv);
        } else {
            cvContainer.classList.add('d-none');
        }

        // Status handling in buttons
        const btnAccept = document.getElementById('btnEmailAccept');
        const btnRefuse = document.getElementById('btnEmailRefuse');
        const statusArea = document.getElementById('modalStatusArea');
        
        btnAccept.classList.remove('d-none');
        btnRefuse.classList.remove('d-none');
        if (statusArea) statusArea.innerHTML = '';

        if (data.statut === 'acceptee') {
            btnRefuse.classList.add('d-none');
            if (statusArea) statusArea.innerHTML = '<span class="badge rounded-pill px-3 py-2" style="background: #00ffcc; color: #0a0e27; font-weight: 700;"><i class="fas fa-check me-1"></i> Acceptée</span>';
        } else if (data.statut === 'refusee') {
            btnAccept.classList.add('d-none');
            if (statusArea) statusArea.innerHTML = '<span class="badge rounded-pill px-3 py-2" style="background: #ff6b6b; color: #0a0e27; font-weight: 700;"><i class="fas fa-times me-1"></i> Refusée</span>';
        }

        // Show Modal
        const modal = new bootstrap.Modal(document.getElementById('candidateModal'));
        modal.show();
    }

    function generateEmail(type) {
        if (!currentCandidateId) return;

        const btnAccept = document.getElementById('btnEmailAccept');
        const btnRefuse = document.getElementById('btnEmailRefuse');
        const originalTextAccept = btnAccept.innerHTML;
        const originalTextRefuse = btnRefuse.innerHTML;
        const loadingHtml = '<i class="fas fa-spinner fa-spin me-1"></i> Génération...';

        btnAccept.disabled = true;
        btnRefuse.disabled = true;
        if (type === 'acceptation') btnAccept.innerHTML = loadingHtml;
        else btnRefuse.innerHTML = loadingHtml;

        const formData = new FormData();
        formData.append('id', currentCandidateId);
        formData.append('type', type);

        fetch('index.php?action=generate_email', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
                return;
            }

            document.getElementById('emailGeneratedSubject').innerText = data.sujet;
            document.getElementById('emailGeneratedBody').innerText = data.corps;
            document.getElementById('emailGeneratedContainer').classList.remove('d-none');

            // Update buttons to reflect new status
            const statusColor = type === 'acceptation' ? '#00ffcc' : '#ff6b6b';
            const statusLabel = type === 'acceptation' ? 'Accepté' : 'Refusé';
            btnAccept.style.display = 'none';
            btnRefuse.style.display = 'none';

            const statusArea = document.getElementById('modalStatusArea');
            statusArea.innerHTML = '';
            
            const statusBadge = document.createElement('span');
            statusBadge.className = 'badge rounded-pill px-3 py-2 me-2';
            statusBadge.style.background = statusColor;
            statusBadge.style.color = '#0a0e27';
            statusBadge.style.fontWeight = '700';
            const iconClass = type === 'acceptation' ? 'fa-check' : 'fa-times';
            statusBadge.innerHTML = '<i class="fas ' + iconClass + ' me-1"></i> ' + statusLabel;
            statusArea.appendChild(statusBadge);
            
            // Badge email envoyé
            if (data.sent) {
                const sentBadge = document.createElement('span');
                sentBadge.className = 'badge rounded-pill px-3 py-2';
                sentBadge.style.background = '#00ccff';
                sentBadge.style.color = '#0a0e27';
                sentBadge.style.fontWeight = '600';
                sentBadge.style.fontSize = '11px';
                sentBadge.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Email envoyé à ' + data.recipient;
                statusArea.appendChild(sentBadge);
            }
        })
        .catch(err => {
            alert('Erreur réseau : ' + err);
        })
        .finally(() => {
            btnAccept.disabled = false;
            btnRefuse.disabled = false;
            btnAccept.innerHTML = originalTextAccept;
            btnRefuse.innerHTML = originalTextRefuse;
        });
    }

    function copyEmail() {
        const subject = document.getElementById('emailGeneratedSubject').innerText;
        const body = document.getElementById('emailGeneratedBody').innerText;
        const text = 'SUJET: ' + subject + '\n\n' + body;
        navigator.clipboard.writeText(text).then(() => {
            alert('Email copié dans le presse-papiers !');
        });
    }
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
