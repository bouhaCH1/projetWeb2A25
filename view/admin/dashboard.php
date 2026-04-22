<?php
$pageTitle = 'Tableau de bord Admin';
include __DIR__ . '/../layout/dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Vue d'ensemble</div>
        <div class="page-header-sub">Statistiques de la plateforme et actions rapides</div>
    </div>
    <a href="/workwave/Controller/index.php?action=admin_add_user" class="btn btn-primary">+ Ajouter un utilisateur</a>
</div>

<!-- Stats row -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-card-label">Utilisateurs totaux</div>
        <div class="stat-card-value"><?= $stats['total'] ?></div>
        <div class="stat-card-sub">Comptes enregistrés</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Candidats</div>
        <div class="stat-card-value"><?= $stats['job_seeker'] ?></div>
        <div class="stat-card-sub">Candidats actifs</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Employeurs</div>
        <div class="stat-card-value"><?= $stats['employer'] ?></div>
        <div class="stat-card-sub">Entreprises recrutant</div>
    </div>


<!-- Flash messages -->
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger"><ul>
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </ul></div>
<?php endif; ?>

<!-- Quick actions -->
<div class="dsh-card">
    <div class="dsh-card-head">
        <div class="dsh-card-title">Actions rapides</div>
    </div>
    <div class="action-grid">
        <a href="/workwave/Controller/index.php?action=admin_users" class="action-card">
            <div class="action-card-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/><path d="M16 3.13a4 4 0 010 7.75"/><path d="M21 21v-2a4 4 0 00-3-3.85"/></svg>
            </div>
            <div class="action-card-title">Gérer les utilisateurs</div>
            <div class="action-card-desc">Afficher, modifier ou supprimer des comptes</div>
        </a>
        <a href="/workwave/Controller/index.php?action=admin_add_user" class="action-card">
            <div class="action-card-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4"/><line x1="17" y1="11" x2="17" y2="17"/><line x1="14" y1="14" x2="20" y2="14"/></svg>
            </div>
            <div class="action-card-title">Ajouter un utilisateur</div>
            <div class="action-card-desc">Créer manuellement un compte candidat ou employeur</div>
        </a>
        <a href="/workwave/Controller/index.php" class="action-card">
            <div class="action-card-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            </div>
            <div class="action-card-title">Site public</div>
            <div class="action-card-desc">Aller sur la page d'accueil publique</div>
        </a>
    </div>
</div>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
