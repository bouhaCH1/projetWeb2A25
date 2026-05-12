<?php require_once dirname(__DIR__) . '/layout/header.php'; ?>
<div class="dashboard-container">
<div class="container"><div class="row"><div class="col-md-3"><div class="glass-card">
        <div class="sidebar-header">
            <img src="view/assets/logo.png" class="animated-logo" alt="Logo">
            <h4>Work Wave</h4>
            <small>Administration</small>
        </div>
        <div class="sidebar-menu d-flex flex-column gap-3 mt-4">
            <a href="index.php?action=admin-dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="index.php?action=admin-pending-portfolios"><i class="fas fa-clock"></i> Portfolios en attente</a>
            <a href="index.php?action=admin-approved-portfolios"><i class="fas fa-check-circle"></i> Portfolios validés</a>
            <a href="index.php?action=admin-pending-jobs"><i class="fas fa-briefcase"></i> Offres d'emploi</a>
            <a href="index.php?action=admin-clients"><i class="fas fa-users"></i> Clients</a>
            <a href="index.php?action=admin-entreprises" class="active"><i class="fas fa-building"></i> Entreprises</a>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <a href="index.php?action=logout" style="color: #e0e0e0;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>

    </div><div class="col-md-9">
        <div class="top-bar">
            <h4><i class="fas fa-building"></i> Liste des entreprises inscrites</h4>
            <a href="index.php?action=admin-dashboard" class="btn btn-outline-secondary btn-sm">← Retour</a>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Entreprise</th>
                        <th>Date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entreprises)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune entreprise inscrite</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($entreprises as $e): ?>
                            <tr>
                                <td><?= $e['id'] ?></td>
                                <td><?= htmlspecialchars($e['full_name'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($e['username']) ?></td>
                                <td><?= htmlspecialchars($e['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($e['company'] ?? '-') ?></td>
                                <td><?= date('d/m/Y', strtotime($e['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div></div></div>
</div>
<?php require_once dirname(__DIR__) . '/layout/footer.php'; ?>
