<?php
$pageTitle = 'Tableau de bord Admin';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h6 class="mb-0">Vue d'ensemble - Statistiques de la plateforme</h6>
    <a href="/workwave/Controller/index.php?action=admin_add_user" class="btn btn-primary m-2">+ Ajouter un utilisateur</a>
</div>

<!-- Flash messages -->
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            <?php foreach ($_SESSION['errors'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Stats row -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-users fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Utilisateurs totaux</p>
                <h6 class="mb-0 fs-4"><?= $stats['total'] ?></h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-user-tie fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Candidats</p>
                <h6 class="mb-0 fs-4"><?= $stats['job_seeker'] ?></h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-building fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Employeurs</p>
                <h6 class="mb-0 fs-4"><?= $stats['employer'] ?></h6>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #eb1616;">
            <i class="fa fa-user-plus fa-3x text-primary"></i>
            <div class="ms-3 text-end">
                <p class="mb-2">Nouveaux ce mois-ci</p>
                <h6 class="mb-0 fs-4">
                    <?= $stats['new_this_month'] ?? 0 ?>
                    <?php if (($stats['new_this_month'] ?? 0) > 0): ?>
                        <span class="badge bg-success ms-2">+ Nouveaux</span>
                    <?php endif; ?>
                </h6>
            </div>
        </div>
    </div>
</div>

<!-- Quick actions -->
<div class="bg-secondary text-center rounded p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h6 class="mb-0">Actions rapides</h6>
    </div>
    <div class="row g-4">
        <div class="col-sm-12 col-md-4">
            <div class="h-100 bg-dark rounded p-4 d-flex flex-column align-items-center justify-content-center text-center shadow-sm" style="transition: .3s; cursor: pointer;" onclick="window.location.href='/workwave/Controller/index.php?action=admin_users'" onmouseover="this.classList.add('bg-secondary');this.classList.remove('bg-dark');" onmouseout="this.classList.add('bg-dark');this.classList.remove('bg-secondary');">
                <i class="fa fa-users-cog fa-3x text-primary mb-3"></i>
                <h6 class="mb-2">Gérer les utilisateurs</h6>
                <p class="mb-0 text-muted">Afficher, modifier ou supprimer des comptes</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="h-100 bg-dark rounded p-4 d-flex flex-column align-items-center justify-content-center text-center shadow-sm" style="transition: .3s; cursor: pointer;" onclick="window.location.href='/workwave/Controller/index.php?action=admin_add_user'" onmouseover="this.classList.add('bg-secondary');this.classList.remove('bg-dark');" onmouseout="this.classList.add('bg-dark');this.classList.remove('bg-secondary');">
                <i class="fa fa-user-plus fa-3x text-primary mb-3"></i>
                <h6 class="mb-2">Ajouter un utilisateur</h6>
                <p class="mb-0 text-muted">Créer manuellement un compte</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="h-100 bg-dark rounded p-4 d-flex flex-column align-items-center justify-content-center text-center shadow-sm" style="transition: .3s; cursor: pointer;" onclick="window.location.href='/workwave/Controller/index.php'" onmouseover="this.classList.add('bg-secondary');this.classList.remove('bg-dark');" onmouseout="this.classList.add('bg-dark');this.classList.remove('bg-secondary');">
                <i class="fa fa-globe fa-3x text-primary mb-3"></i>
                <h6 class="mb-2">Site public</h6>
                <p class="mb-0 text-muted">Aller sur la page d'accueil publique</p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
