<?php
$pageTitle = 'Sécurité & Confidentialité';
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_header.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_header.php';
}
?>

<div class="page-header">
    <div>
        <div class="page-header-title">Sécurité & Confidentialité</div>
        <div class="page-header-sub">Gérez votre compte, vos données (RGPD) et consultez votre historique</div>
    </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <?php foreach ($_SESSION['errors'] as $e): ?>
            <div><?= htmlspecialchars($e) ?></div>
        <?php endforeach; unset($_SESSION['errors']); ?>
    </div>
<?php endif; ?>

<div style="display:flex; flex-wrap:wrap; gap:20px; align-items:flex-start;">
    
    <!-- Section 1: Historique de connexion -->
    <div class="dsh-card" style="flex:1; min-width:300px; padding:24px;">
        <h4 style="font-weight:700; margin-bottom:15px; border-bottom:1px solid var(--border-color); padding-bottom:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle; margin-right:8px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Historique de connexion
        </h4>
        <p style="font-size: .85rem; color:#666; margin-bottom:15px;">Dernières connexions à votre compte. Si vous remarquez une activité suspecte, changez votre mot de passe immédiatement.</p>
        
        <table style="width:100%; border-collapse:collapse; font-size:.85rem;">
            <thead>
                <tr>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid var(--border-color);">Date & Heure</th>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid var(--border-color);">Adresse IP</th>
                    <th style="padding:10px; text-align:left; border-bottom:1px solid var(--border-color);">Navigateur / Appareil</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="3" style="padding:15px; text-align:center;">Aucun historique trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($history as $log): ?>
                    <tr>
                        <td style="padding:10px; border-bottom:1px solid var(--border-color);"><?= htmlspecialchars($log['login_time']) ?></td>
                        <td style="padding:10px; border-bottom:1px solid var(--border-color);"><?= htmlspecialchars($log['ip_address']) ?></td>
                        <td style="padding:10px; border-bottom:1px solid var(--border-color); font-size:.75rem; color:#555;"><?= htmlspecialchars(substr($log['user_agent'], 0, 50)) ?>...</td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Section 2: RGPD (Export & Suppression) -->
    <div style="flex:1; min-width:300px; display:flex; flex-direction:column; gap:20px;">
        
        <div class="dsh-card" style="padding:24px;">
            <h4 style="font-weight:700; margin-bottom:15px; border-bottom:1px solid var(--border-color); padding-bottom:10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle; margin-right:8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Portabilité des données (RGPD)
            </h4>
            <p style="font-size: .85rem; color:#666; margin-bottom:15px;">Conformément au RGPD, vous avez le droit de télécharger une copie de l'ensemble de vos données personnelles.</p>
            <a href="/workwave/Controller/index.php?action=export_data" class="btn btn-secondary" style="background:#27ae60; color:#fff; border:none; text-align:center; width:100%;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle; margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Télécharger mes données (JSON)</a>
        </div>

        <div class="dsh-card" style="padding:24px; border:1px solid rgba(220,53,53,.3); box-shadow: 0 4px 15px rgba(220,53,53,.05);">
            <h4 style="font-weight:700; margin-bottom:15px; color:#c0392b; border-bottom:1px solid rgba(220,53,53,.2); padding-bottom:10px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle; margin-right:8px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Zone de Danger
            </h4>
            <p style="font-size: .85rem; color:#666; margin-bottom:15px;">La suppression de votre compte est définitive. Toutes vos données seront irrémédiablement perdues.</p>
            
            <form action="/workwave/Controller/index.php?action=delete_account" method="POST" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer votre compte définitivement ?');">
                <label style="font-size:.75rem; color:#c0392b; font-weight:700;">Confirmez avec votre mot de passe :</label>
                <input type="password" name="password" required style="border-color:rgba(220,53,53,.5); margin-bottom:12px;">
                <button type="submit" class="btn btn-danger" style="width:100%;">Supprimer mon compte</button>
            </form>
        </div>

    </div>
</div>

<?php
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_footer.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_footer.php';
}
?>
