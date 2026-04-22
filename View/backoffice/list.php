<?php
$activePage = 'list';
$pageTitle  = 'Gestion des Missions';
$pageIcon   = 'list';

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
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
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
    .badge-ouverte { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; }
    .badge-en_cours { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #1a1a2e; }
    .badge-terminee { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; }
    .badge-annulee { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; }
    .budget-text {
        color: #d4af37;
        font-weight: 700;
        font-size: 15px;
    }
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
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .action-btn.edit {
        background: rgba(212, 175, 55, 0.2);
        color: #d4af37;
        border: 1px solid #d4af37;
    }
    .action-btn.edit:hover {
        background: #d4af37;
        color: #1a1a2e;
    }
    .action-btn.view {
        background: rgba(0, 189, 254, 0.2);
        color: #00bdfe;
        border: 1px solid #00bdfe;
    }
    .action-btn.view:hover {
        background: #00bdfe;
        color: #1a1a2e;
    }
    .action-btn.delete {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
        border: 1px solid #dc3545;
    }
    .action-btn.delete:hover {
        background: #dc3545;
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
</style>

<div class="premium-card">
    <div class="premium-card-header">
        <h4><i class="fas fa-briefcase"></i> Liste des Missions</h4>
        <a href="index.php?action=create" class="premium-btn">
            <i class="fas fa-plus"></i> Nouvelle Mission
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (empty($missions)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>Aucune mission</h5>
                <p>Commencez par ajouter votre première mission.</p>
                <a href="index.php?action=create" class="premium-btn">
                    <i class="fas fa-plus"></i> Ajouter une mission
                </a>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Budget</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Statut</th>
                        <th>Compétences</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($missions as $m): ?>
                    <tr>
                        <td><strong>#<?= $m['id'] ?></strong></td>
                        <td><strong><?= htmlspecialchars($m['titre']) ?></strong></td>
                        <td><span class="budget-text"><?= number_format($m['budget'], 0, ',', ' ') ?> €</span></td>
                        <td><?= date('d/m/Y', strtotime($m['date_debut'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($m['date_fin'])) ?></td>
                        <td>
                            <span class="badge-premium badge-<?= $m['statut'] ?>">
                                <?= ucfirst(str_replace('_', ' ', $m['statut'])) ?>
                            </span>
                        </td>
                        <td><small style="color: #888;"><?= htmlspecialchars($m['competences']) ?></small></td>
                        <td>
                            <a href="index.php?action=edit&id=<?= $m['id'] ?>" class="action-btn edit" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?action=candidatures&mission_id=<?= $m['id'] ?>" class="action-btn view" title="Candidatures">
                                <i class="fas fa-user-check"></i>
                            </a>
                            <a href="index.php?action=delete&id=<?= $m['id'] ?>"
                               class="action-btn delete"
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
</div>
<?php
$content = ob_get_clean();
require_once 'layout.php';
?>