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
        <h4 style="font-weight:700; margin-bottom:15px; border-bottom:1px solid rgba(0,255,204,0.1); padding-bottom:10px; color:#fff; font-size:0.95rem;">
            <i class="fa fa-shield-alt" style="margin-right:8px; color:#00ffcc;"></i>
            Historique de connexion
        </h4>
        <p style="font-size: .85rem; color:#666; margin-bottom:15px;">Dernières connexions à votre compte. Si vous remarquez une activité suspecte, changez votre mot de passe immédiatement.</p>
        
        <table style="width:100%; border-collapse:collapse; font-size:.83rem; color:#bbb;">
            <thead>
                <tr>
                    <th style="padding:10px 8px; text-align:left; border-bottom:1px solid rgba(0,255,204,0.08); color:#00ffcc; font-weight:600; font-size:0.72rem; text-transform:uppercase;">Date & Heure</th>
                    <th style="padding:10px 8px; text-align:left; border-bottom:1px solid rgba(0,255,204,0.08); color:#00ffcc; font-weight:600; font-size:0.72rem; text-transform:uppercase;">Adresse IP</th>
                    <th style="padding:10px 8px; text-align:left; border-bottom:1px solid rgba(0,255,204,0.08); color:#00ffcc; font-weight:600; font-size:0.72rem; text-transform:uppercase;">Appareil</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr><td colspan="3" style="padding:20px 8px; text-align:center; color:#444;">Aucun historique trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($history as $log): ?>
                    <tr style="transition:background 0.15s;" onmouseover="this.style.background='rgba(0,255,204,0.03)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:10px 8px; border-bottom:1px solid rgba(255,255,255,0.04);"><?= htmlspecialchars($log['login_time']) ?></td>
                        <td style="padding:10px 8px; border-bottom:1px solid rgba(255,255,255,0.04);"><?= htmlspecialchars($log['ip_address']) ?></td>
                        <td style="padding:10px 8px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:.75rem; color:#555;"><?= htmlspecialchars(substr($log['user_agent'], 0, 50)) ?>...</td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Section 2: Sécurité du compte (2FA & RGPD) -->
    <div style="flex:1; min-width:300px; display:flex; flex-direction:column; gap:20px;">
        
        <!-- 2FA -->
        <?php
        // Fetch current 2FA status
        $userObj = new User();
        $userData = $userObj->getById((int)$_SESSION['user_id']);
        $is2faEnabled = ((int)($userData['two_factor_enabled'] ?? 0)) === 1;
        ?>
        <div class="dsh-card" style="padding:24px;">
            <h4 style="font-weight:700; margin-bottom:12px; border-bottom:1px solid rgba(0,255,204,0.1); padding-bottom:10px; color:#fff; font-size:0.95rem;">
                <i class="fa fa-lock" style="margin-right:8px; color:#00ffcc;"></i>
                Double Authentification (2FA)
            </h4>
            <p style="font-size:0.83rem; color:#666; margin-bottom:16px; line-height:1.6;">Ajoutez une couche de sécurité supplémentaire. Lors de la connexion, vous devrez entrer un code de vérification.</p>
            
            <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 16px; border-radius:8px; background:rgba(255,255,255,0.02); border:1px solid rgba(0,255,204,0.08);">
                <div>
                    <div style="font-weight:700; font-size:0.88rem; color:<?= $is2faEnabled ? '#00ffcc' : '#aaa' ?>;">
                        <?= $is2faEnabled ? '✅ 2FA est Activée' : '⚠️ 2FA est Désactivée' ?>
                    </div>
                    <div style="font-size:0.75rem; color:#555; margin-top:3px;">Protégez votre compte contre les accès non autorisés.</div>
                </div>
                <a href="/workwave/Controller/index.php?action=toggle_2fa" style="
                    display:inline-flex; align-items:center; gap:6px;
                    padding:8px 16px; border-radius:6px; font-size:0.82rem; font-weight:700;
                    text-decoration:none; transition:all 0.18s; white-space:nowrap;
                    <?= $is2faEnabled
                        ? 'background:rgba(255,107,107,0.1); color:#ff6b6b; border:1px solid rgba(255,107,107,0.3);'
                        : 'background:rgba(0,255,204,0.1); color:#00ffcc; border:1px solid rgba(0,255,204,0.3);'
                    ?>
                ">
                    <i class="fa <?= $is2faEnabled ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                    <?= $is2faEnabled ? 'Désactiver' : 'Activer' ?>
                </a>
            </div>
        </div>

        <div class="dsh-card" style="padding:24px;">
            <h4 style="font-weight:700; margin-bottom:12px; border-bottom:1px solid rgba(0,255,204,0.1); padding-bottom:10px; color:#fff; font-size:0.95rem;">
                <i class="fa fa-download" style="margin-right:8px; color:#00ffcc;"></i>
                Portabilité des données (RGPD)
            </h4>
            <p style="font-size:0.83rem; color:#666; margin-bottom:16px; line-height:1.6;">Conformément au RGPD, vous avez le droit de télécharger une copie de l'ensemble de vos données personnelles.</p>
            <a href="/workwave/Controller/index.php?action=export_data" style="
                display:inline-flex; align-items:center; justify-content:center; gap:8px;
                width:100%; padding:10px 18px; border-radius:7px;
                background:rgba(0,255,204,0.08); color:#00ffcc;
                border:1px solid rgba(0,255,204,0.25);
                font-size:0.85rem; font-weight:600; text-decoration:none;
                transition:background 0.18s;
            " onmouseover="this.style.background='rgba(0,255,204,0.14)'" onmouseout="this.style.background='rgba(0,255,204,0.08)'">
                <i class="fa fa-download"></i> Télécharger mes données (JSON)
            </a>
        </div>

        <div class="dsh-card" style="padding:24px; border:1px solid rgba(255,107,107,0.2); background:rgba(255,107,107,0.02);">
            <h4 style="font-weight:700; margin-bottom:12px; color:#ff6b6b; border-bottom:1px solid rgba(255,107,107,0.15); padding-bottom:10px; font-size:0.95rem;">
                <i class="fa fa-exclamation-triangle" style="margin-right:8px;"></i>
                Zone de Danger
            </h4>
            <p style="font-size:0.83rem; color:#666; margin-bottom:16px; line-height:1.6;">La suppression de votre compte est définitive. Toutes vos données seront irrémédiablement perdues.</p>
            
            <form action="/workwave/Controller/index.php?action=delete_account" method="POST" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer votre compte définitivement ?');">
                <label style="font-size:0.72rem; color:#ff6b6b; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Confirmez avec votre mot de passe :</label>
                <input type="password" name="password" required style="border-color:rgba(255,107,107,0.3); margin-bottom:12px;">
                <button type="submit" style="
                    display:inline-flex; align-items:center; justify-content:center; gap:8px;
                    width:100%; padding:10px 18px; border-radius:7px;
                    background:rgba(255,107,107,0.1); color:#ff6b6b;
                    border:1px solid rgba(255,107,107,0.3);
                    font-size:0.85rem; font-weight:700; cursor:pointer;
                    transition:background 0.18s;
                ">
                    <i class="fa fa-trash-alt"></i> Supprimer mon compte
                </button>
            </form>
        </div>

        <!-- Section 3: Vérification d'identité OCR (Métier Avancé) -->
        <?php $isVerified = (isset($_SESSION['user_verified']) && $_SESSION['user_verified'] === 1); ?>
        <div class="dsh-card" style="padding:24px; border:1px solid <?= $isVerified ? 'rgba(0,255,204,0.3)' : 'rgba(255,193,7,0.3)' ?>; background:<?= $isVerified ? 'rgba(0,255,204,0.02)' : 'rgba(255,193,7,0.02)' ?>;">
            <h4 style="font-weight:700; margin-bottom:12px; color:<?= $isVerified ? '#00ffcc' : '#ffc107' ?>; border-bottom:1px solid <?= $isVerified ? 'rgba(0,255,204,0.15)' : 'rgba(255,193,7,0.15)' ?>; padding-bottom:10px; font-size:0.95rem;">
                <i class="fa fa-id-card" style="margin-right:8px;"></i>
                Vérification d'Identité (OCR IA)
            </h4>
            <p style="font-size:0.83rem; color:#666; margin-bottom:16px; line-height:1.6;">
                <?= $isVerified ? 'Votre identité a été vérifiée avec succès. Vous possédez le badge "Vérifié" public.' : 'Prouvez votre identité en scannant votre pièce d\'identité via notre Intelligence Artificielle OCR pour obtenir un badge de confiance.' ?>
            </p>
            
            <?php if (!$isVerified): ?>
                <a href="/workwave/Controller/index.php?action=verify_identity" style="
                    display:inline-flex; align-items:center; justify-content:center; gap:8px;
                    width:100%; padding:10px 18px; border-radius:7px;
                    background:rgba(255,193,7,0.1); color:#ffc107;
                    border:1px solid rgba(255,193,7,0.3);
                    font-size:0.85rem; font-weight:700; text-decoration:none;
                    transition:background 0.18s;
                " onmouseover="this.style.background='rgba(255,193,7,0.15)'" onmouseout="this.style.background='rgba(255,193,7,0.1)'">
                    <i class="fa fa-camera"></i> Lancer la vérification
                </a>
            <?php else: ?>
                <div style="display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:10px 18px; border-radius:7px; background:rgba(0,255,204,0.1); color:#00ffcc; border:1px solid rgba(0,255,204,0.3); font-size:0.85rem; font-weight:700;">
                    <i class="fa fa-check-circle"></i> Compte Certifié
                </div>
            <?php endif; ?>
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
