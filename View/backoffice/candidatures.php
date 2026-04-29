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
        overflow: hidden;
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

    <!-- Filters Section -->
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
                                <span class="text-muted small"><i class="fas fa-phone me-1"></i> Contact</span>
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
                                    <button class="btn-action-round bg-primary bg-opacity-20 text-primary border-0" 
                                            title="Voir Détails"
                                            onclick="showCandidateDetails(<?= htmlspecialchars(json_encode($c)) ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
            </small>
        </footer>
    <?php endif; ?>
</div>

<!-- Details Modal Forge -->
<div class="modal fade modal-forge" id="candidateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <div id="modalAvatar" class="candidate-avatar" style="width: 50px; height: 50px; font-size: 1.2rem;">--</div>
                    <div>
                        <h5 class="modal-title text-white fw-800 mb-0">Détails du Candidat</h5>
                        <small class="text-muted" id="modalIdLabel">Candidature #0</small>
                    </div>
                </div>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <button type="button" class="btn py-2 px-4 rounded-3 fw-800 text-white border-0 shadow-sm" data-bs-dismiss="modal" style="background: linear-gradient(135deg, #ff6b35, #e63946); font-size: 0.8rem;">
                        <i class="fas fa-arrow-left me-2"></i> RETOUR
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-card-forge">
                                    <span class="label-forge">Email Professionnel</span>
                                    <div id="modalEmail" class="value-forge text-break">--</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-card-forge">
                                    <span class="label-forge">Téléphone</span>
                                    <div id="modalPhone" class="value-forge">--</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column Right: Motivation & CV -->
                    <div class="col-md-7">
                        <div class="info-card-forge h-100 d-flex flex-column">
                            <span class="label-forge">Lettre de Motivation</span>
                            <div id="modalMotivation" class="motivation-box flex-grow-1">--</div>
                            
                            <div id="modalCvContainer" class="mt-4 d-none">
                                <a id="modalCvLink" href="#" target="_blank" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">
                                    <i class="fas fa-file-pdf me-2"></i> Consulter le CV complet
                                </a>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function showCandidateDetails(data) {
        // Populate Data
        document.getElementById('modalIdLabel').innerText = 'Candidature #' + data.id;
        document.getElementById('modalFullName').innerText = data.prenom + ' ' + data.nom;
        document.getElementById('modalAvatar').innerText = (data.prenom[0] + data.nom[0]).toUpperCase();
        document.getElementById('modalMission').innerText = data.mission_titre;
        document.getElementById('modalEmail').innerText = data.email;
        document.getElementById('modalPhone').innerText = data.telephone;
        document.getElementById('modalMotivation').innerText = data.motivation;
        
        // CV handling
        const cvContainer = document.getElementById('modalCvContainer');
        const cvLink = document.getElementById('modalCvLink');
        if (data.cv) {
            cvContainer.classList.remove('d-none');
            cvLink.href = 'uploads/' + encodeURIComponent(data.cv);
        } else {
            cvContainer.classList.add('d-none');
        }

        // Show Modal
        const modal = new bootstrap.Modal(document.getElementById('candidateModal'));
        modal.show();
    }
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
