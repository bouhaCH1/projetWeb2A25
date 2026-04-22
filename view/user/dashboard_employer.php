<?php
$pageTitle = 'Mon Tableau de Bord';
include __DIR__ . '/../layout/pl_dashboard_header.php';
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Bon retour, <?= htmlspecialchars($_SESSION['user_first_name']) ?>! 👋</div>
        <div class="page-header-sub">Gérez vos offres d'emploi et votre compte</div>
    </div>

</div>

<!-- Quick actions -->
<div class="action-grid" style="margin-bottom:24px;">

    <a href="/workwave/Controller/index.php?action=profile" class="action-card">
        <div class="action-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20v-2a8 8 0 0116 0v2"/></svg>
        </div>
        <div class="action-card-title">Mon Profil</div>
        <div class="action-card-desc">Mettez à jour les informations de votre entreprise et vos coordonnées</div>
    </a>

</div>

<!-- Tips card -->
<div class="dsh-card">
    <div class="dsh-card-head">
        <div class="dsh-card-title">Conseils pour les employeurs</div>
    </div>
    <ul style="color:#888;font-size:.85rem;line-height:2;padding-left:20px;">
        <li>Rédigez des descriptions de poste claires et détaillées pour attirer les bons candidats</li>
        <li>Indiquez le type de contrat et la fourchette de salaire pour améliorer la visibilité</li>
        <li>Gardez vos annonces à jour — supprimez rapidement les offres expirées</li>
    </ul>
</div>

<?php include __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>
