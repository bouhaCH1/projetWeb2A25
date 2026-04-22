<?php
$activePage = 'candidatures';
$pageTitle = 'Candidatures';
$pageIcon = 'user-check';

ob_start();
?>
<style>
    .premium-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 15px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        overflow: hidden;
    }
    .premium-card-header {
        background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .premium-card-header h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .premium-btn {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #d4af37;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        border: 2px solid #d4af37;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .premium-btn:hover {
        background: #d4af37;
        color: #1a1a2e;
    }
    .premium-select {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.8) 0%, rgba(22, 33, 62, 0.8) 100%);
        border: 2px solid rgba(212, 175, 55, 0.4);
        border-radius: 12px;
        padding: 14px 45px 14px 18px;
        color: #fff;
        width: 100%;
        font-size: 14px;
        font-family: 'Libre Franklin', sans-serif;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23d4af37' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .premium-select:hover {
        border-color: rgba(212, 175, 55, 0.7);
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.15);
    }
    .premium-select:focus {
        border-color: #d4af37;
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
    }
    .premium-select option {
        background: #1a1a2e;
        color: #fff;
        padding: 10px;
    }
    .premium-select option:hover {
        background: #d4af37;
        color: #1a1a2e;
    }
    .premium-table {
        width: 100%;
        border-collapse: collapse;
    }
    .premium-table thead {
        background: rgba(212, 175, 55, 0.1);
    }
    .premium-table thead th {
        font-family: 'Libre Franklin', sans-serif;
        color: #d4af37;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 20px 15px;
        text-align: left;
        border-bottom: 2px solid rgba(212, 175, 55, 0.3);
    }
    .premium-table tbody tr {
        border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        transition: all 0.3s ease;
    }
    .premium-table tbody tr:hover {
        background: rgba(212, 175, 55, 0.05);
    }
    .premium-table tbody td {
        padding: 20px 15px;
        color: #b8b8b8;
        font-size: 14px;
    }
    .premium-table tbody td strong {
        color: #fff;
        font-weight: 600;
    }
    .badge-premium {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .badge-en_attente { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; }
    .badge-acceptee { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; }
    .badge-refusee { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; }
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-right: 5px;
        border: none;
        cursor: pointer;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .action-btn.accept {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid #28a745;
    }
    .action-btn.accept:hover, .action-btn.accept.active {
        background: #28a745;
        color: white;
    }
    .action-btn.reject {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        border: 1px solid #dc3545;
    }
    .action-btn.reject:hover, .action-btn.reject.active {
        background: #dc3545;
        color: white;
    }
    .action-btn.delete {
        background: rgba(108, 117, 125, 0.2);
        color: #adb5bd;
        border: 1px solid #adb5bd;
    }
    .action-btn.delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 64px;
        color: rgba(212, 175, 55, 0.3);
        margin-bottom: 20px;
    }
    .empty-state h5 {
        color: #d4af37;
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        margin-bottom: 15px;
    }
    .empty-state p {
        color: #888;
        margin-bottom: 25px;
    }
    .date-text {
        color: #d4af37;
        font-size: 12px;
    }
</style>

<div class="premium-card">
    <div class="premium-card-header">
        <h4><i class="fas fa-user-check"></i> Liste des Candidatures</h4>
        <a href="index.php?action=index" class="premium-btn">
            <i class="fas fa-briefcase"></i> Voir les missions
        </a>
    </div>
    <div class="card-body border-bottom" style="background: rgba(212, 175, 55, 0.05); padding: 20px 30px;">
        <form method="GET" action="index.php" class="row g-2 align-items-center">
            <input type="hidden" name="action" value="candidatures">
            <div class="col-md-8">
                <select name="mission_id" class="premium-select">
                    <option value="">Toutes les missions</option>
                    <?php foreach ($missions as $m): ?>
                        <option value="<?= (int)$m['id'] ?>" <?= ($selectedMissionId === (int)$m['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['titre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="premium-btn" style="padding: 10px 20px;">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
                <a href="index.php?action=candidatures" class="premium-btn" style="background: transparent; color: #b8b8b8; border: 1px solid rgba(212, 175, 55, 0.3);">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <?php if (empty($candidatures)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>Aucune candidature</h5>
                <p>Il n'y a pas encore de candidatures pour vos missions.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
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
                                <td><strong>#<?= (int)$c['id'] ?></strong></td>
                                <td><strong><?= htmlspecialchars($c['mission_titre']) ?></strong></td>
                                <td><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($c['email']) ?>" style="color: #00bdfe; text-decoration: none;">
                                        <?= htmlspecialchars($c['email']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($c['telephone']) ?></td>
                                <td>
                                    <small style="color: #888;"><?= nl2br(htmlspecialchars(substr($c['motivation'], 0, 100))) ?>...</small>
                                </td>
                                <td>
                                    <?php 
                                        $statutClass = 'en_attente';
                                        $statutText = 'En attente';
                                        if (isset($c['statut'])) {
                                            if ($c['statut'] === 'acceptee') { $statutClass = 'acceptee'; $statutText = 'Acceptée'; }
                                            if ($c['statut'] === 'refusee') { $statutClass = 'refusee'; $statutText = 'Refusée'; }
                                        }
                                    ?>
                                    <span class="badge-premium badge-<?= $statutClass ?>"><?= $statutText ?></span>
                                </td>
                                <td>
                                    <div class="text-nowrap mb-1">
                                        <small class="date-text d-block mb-2"><i class="fas fa-clock"></i> <?= !empty($c['created_at']) ? date('d/m/Y H:i', strtotime($c['created_at'])) : '-' ?></small>
                                        <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=acceptee" class="action-btn accept <?= (isset($c['statut']) && $c['statut'] === 'acceptee') ? 'active' : '' ?>" title="Accepter"><i class="fas fa-check"></i></a>
                                        <a href="index.php?action=update_candidature_statut&id=<?= $c['id'] ?>&statut=refusee" class="action-btn reject <?= (isset($c['statut']) && $c['statut'] === 'refusee') ? 'active' : '' ?>" title="Refuser"><i class="fas fa-times"></i></a>
                                        <a href="index.php?action=delete_candidature&id=<?= $c['id'] ?>" class="action-btn delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?');"><i class="fas fa-trash"></i></a>
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
