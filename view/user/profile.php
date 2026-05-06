<?php
$pageTitle = 'Mon Profil';
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin';
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_header.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_header.php';
}

$fieldErrors = $_SESSION['field_errors'] ?? []; unset($_SESSION['field_errors']);
$successMsg = $_SESSION['success'] ?? ''; unset($_SESSION['success']);
?>

<?php if ($isAdmin): ?>
    <!-- ================= ADMIN LAYOUT (Darkpan) ================= -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h6 class="mb-0">Mon Profil</h6>
            <small class="text-muted">Mettez à jour vos informations personnelles et votre photo de profil</small>
        </div>
    </div>

    <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i><?= htmlspecialchars($successMsg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="bg-secondary rounded p-4 mb-4" style="max-width: 800px;">
        <!-- Avatar preview -->
        <div class="d-flex align-items-center border-bottom border-dark pb-4 mb-4">
            <div class="position-relative me-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark" style="width:80px;height:80px;overflow:hidden;background:linear-gradient(135deg,#C4A15A,#7a5f30);font-size:2rem;">
                    <?php if (!empty($data['profile_pic'])): ?>
                        <img src="/workwave/<?= htmlspecialchars($data['profile_pic']) ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <?= strtoupper(substr($data['first_name'], 0, 1)) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <h5 class="mb-1 text-white"><?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                <p class="mb-2 text-muted"><?= htmlspecialchars($data['email']) ?></p>
                <span class="badge bg-danger">Administrateur</span>
            </div>
        </div>

        <form action="/workwave/Controller/index.php?action=profile_update" method="POST" enctype="multipart/form-data" novalidate>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label text-muted">Prénom</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>" class="form-control bg-dark border-0 <?= !empty($fieldErrors['first_name']) ? 'is-invalid' : '' ?>">
                    <?php if (!empty($fieldErrors['first_name'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label text-muted">Nom</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>" class="form-control bg-dark border-0 <?= !empty($fieldErrors['last_name']) ? 'is-invalid' : '' ?>">
                    <?php if (!empty($fieldErrors['last_name'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label text-muted">E-mail <small>(ne peut pas être modifié)</small></label>
                    <input type="text" class="form-control bg-dark border-0" value="<?= htmlspecialchars($data['email']) ?>" disabled>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label text-muted">Téléphone <small>(facultatif)</small></label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>" class="form-control bg-dark border-0 <?= !empty($fieldErrors['phone']) ? 'is-invalid' : '' ?>">
                    <?php if (!empty($fieldErrors['phone'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted">Photo de profil <small>(JPG, PNG, GIF — max 2 Mo)</small></label>
                <input type="file" name="profile_pic" accept="image/*" class="form-control bg-dark border-0">
            </div>

            <hr class="border-dark my-4">

            <h6 class="mb-3">Changer le mot de passe</h6>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label text-muted">Nouveau mot de passe</label>
                    <input type="password" name="new_password" class="form-control bg-dark border-0 <?= !empty($fieldErrors['new_password']) ? 'is-invalid' : '' ?>">
                    <?php if (!empty($fieldErrors['new_password'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['new_password']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password" class="form-control bg-dark border-0 <?= !empty($fieldErrors['confirm_password']) ? 'is-invalid' : '' ?>">
                    <?php if (!empty($fieldErrors['confirm_password'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($fieldErrors['confirm_password']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Sauvegarder les modifications</button>
        </form>
    </div>

<?php else: ?>
    <!-- ================= USER LAYOUT (Graph Page) ================= -->
    
    <div class="page-header" style="max-width: 800px; margin: 0 auto 30px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 class="page-header-title" style="margin-bottom: 0;">Mon Profil</h1>
            <div class="page-header-sub">Mettez à jour vos informations personnelles et votre photo de profil</div>
        </div>
        <button onclick="window.print()" style="padding:10px 16px; background:linear-gradient(135deg,#a78bfa,#f472b6); border:none; border-radius:8px; color:#fff; font-weight:700; font-size:0.9rem; cursor:pointer; box-shadow:0 4px 15px rgba(167,139,250,0.3); transition:transform 0.2s;">
            📄 Télécharger mon CV PDF
        </button>
    </div>

    <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success" style="max-width: 800px; margin: 0 auto 20px;">
            <i class="fa fa-check-circle" style="margin-right: 8px;"></i><?= htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>

    <div class="dsh-card" style="max-width: 800px; margin: 0 auto;">
        
        <!-- Avatar preview -->
        <div style="display: flex; align-items: center; border-bottom: 1px solid rgba(0, 255, 204, 0.2); padding-bottom: 25px; margin-bottom: 25px;">
            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: linear-gradient(135deg, #00ffcc, #00b3ff); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: #000; margin-right: 20px;">
                <?php if (!empty($data['profile_pic'])): ?>
                    <img src="/workwave/<?= htmlspecialchars($data['profile_pic']) ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                    <?= strtoupper(substr($data['first_name'], 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div>
                <h2 style="font-size: 1.4rem; color: #fff; margin: 0 0 5px 0;"><?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?></h2>
                <div style="color: #a0a0a0; font-size: 0.9rem; margin-bottom: 8px;"><?= htmlspecialchars($data['email']) ?></div>
                <span style="display: inline-block; padding: 4px 12px; background: rgba(0, 255, 204, 0.1); border: 1px solid rgba(0, 255, 204, 0.3); border-radius: 20px; font-size: 0.75rem; font-weight: bold; color: #00ffcc;">
                    <?php
                    if ($data['role'] === 'job_seeker') echo 'Candidat';
                    elseif ($data['role'] === 'employer') echo 'Employeur';
                    else echo htmlspecialchars($data['role']);
                    ?>
                </span>
            </div>
        </div>

        <form action="/workwave/Controller/index.php?action=profile_update" method="POST" enctype="multipart/form-data" novalidate>
            <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <label>Prénom</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($data['first_name']) ?>">
                    <?php if (!empty($fieldErrors['first_name'])): ?>
                        <div class="field-err"><?= htmlspecialchars($fieldErrors['first_name']) ?></div>
                    <?php endif; ?>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <label>Nom</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name']) ?>">
                    <?php if (!empty($fieldErrors['last_name'])): ?>
                        <div class="field-err"><?= htmlspecialchars($fieldErrors['last_name']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <label>E-mail <span style="text-transform:none; color:#a0a0a0; font-weight:normal;">(ne peut pas être modifié)</span></label>
                    <input type="text" value="<?= htmlspecialchars($data['email']) ?>" disabled style="opacity: 0.5;">
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <label>Téléphone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">
                    <?php if (!empty($fieldErrors['phone'])): ?>
                        <div class="field-err"><?= htmlspecialchars($fieldErrors['phone']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div style="margin-bottom: 35px;">
                <label>Photo de profil <span style="text-transform:none; color:#a0a0a0; font-weight:normal;">(JPG, PNG, GIF — max 2 Mo)</span></label>
                <input type="file" name="profile_pic" accept="image/*" style="padding: 8px;">
            </div>

            <h3 style="font-size: 1.1rem; color: #fff; border-top: 1px solid rgba(0, 255, 204, 0.2); padding-top: 25px; margin-bottom: 15px;">Changer le mot de passe</h3>

            <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <label>Nouveau mot de passe <span style="text-transform:none; color:#a0a0a0; font-weight:normal;">(Laisser vide si inchangé)</span></label>
                    <input type="password" name="new_password">
                    <?php if (!empty($fieldErrors['new_password'])): ?>
                        <div class="field-err"><?= htmlspecialchars($fieldErrors['new_password']) ?></div>
                    <?php endif; ?>
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <label>Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password">
                    <?php if (!empty($fieldErrors['confirm_password'])): ?>
                        <div class="field-err"><?= htmlspecialchars($fieldErrors['confirm_password']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="ww-btn-primary" style="max-width: 300px;">
                <i class="fa fa-save" style="margin-right: 8px;"></i> Sauvegarder les modifications
            </button>
        </form>
    </div>

    <!-- BEAUTIFUL CV TEMPLATE FOR PDF EXPORT -->
    <div id="hiddenCV" style="display:none;">
        <div style="background:#ffffff; color:#333333; padding:40px; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; position:relative; overflow:hidden;">
            <!-- Header section with flat color -->
            <div style="position:absolute; top:0; left:0; width:100%; height:120px; background:#00b3ff;"></div>
            
            <div style="position:relative; z-index:10; display:flex; margin-bottom:40px; margin-top:20px;">
                <div style="width:120px; height:120px; border-radius:50%; border:4px solid #ffffff; background:#eeeeee; overflow:hidden; flex-shrink:0; margin-right:30px;">
                    <?php if (!empty($data['profile_pic'])): ?>
                        <img src="/workwave/<?= htmlspecialchars($data['profile_pic']) ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:3rem; font-weight:bold; color:#888888;">
                            <?= strtoupper(substr($data['first_name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="padding-top:20px;">
                    <h1 style="margin:0; font-size:2.8rem; color:#ffffff; text-transform:uppercase; letter-spacing:1px;">
                        <?= htmlspecialchars($data['first_name'] . ' ' . $data['last_name']) ?>
                    </h1>
                    <div style="font-size:1.4rem; color:#333333; font-weight:300; margin-top:30px; letter-spacing:0.5px;">
                        <?= ($data['role'] === 'job_seeker') ? 'Candidat Professionnel' : 'Employeur / Recruteur' ?>
                        <?php if(!empty($data['is_verified'])): ?>
                            <span style="color:#22c55e; font-size:1rem; font-weight:bold; margin-left:10px;">✓ Vérifié</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Body Layout -->
            <div style="display:flex;">
                <!-- Left Column (Contact & Skills) -->
                <div style="width:35%; padding-right:20px;">
                    <div style="margin-bottom:30px;">
                        <h3 style="font-size:1.1rem; color:#00b3ff; border-bottom:2px solid #00b3ff; padding-bottom:5px; margin-bottom:15px; text-transform:uppercase;">Contact</h3>
                        <div style="margin-bottom:10px;">
                            <strong>Email:</strong><br>
                            <span style="color:#555555;"><?= htmlspecialchars($data['email']) ?></span>
                        </div>
                        <div style="margin-bottom:10px;">
                            <strong>Téléphone:</strong><br>
                            <span style="color:#555555;"><?= htmlspecialchars($data['phone'] ?: 'Non spécifié') ?></span>
                        </div>
                        <div style="margin-bottom:10px;">
                            <strong>Plateforme:</strong><br>
                            <span style="color:#555555;">Membre WorkWave</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Experience & Info) -->
                <div style="width:65%; padding-left:20px;">
                    <div style="margin-bottom:30px;">
                        <h3 style="font-size:1.1rem; color:#333333; border-bottom:2px solid #dddddd; padding-bottom:5px; margin-bottom:15px; text-transform:uppercase;">Profil Personnel</h3>
                        <p style="color:#555555; line-height:1.6; font-size:0.95rem;">
                            Passionné par mon domaine, je suis toujours à l'écoute des nouvelles tendances et prêt à relever de nouveaux défis. Rigoureux et autonome, j'aime m'investir pleinement dans les missions qui me sont confiées pour apporter une réelle valeur ajoutée à l'équipe.
                        </p>
                    </div>

                    <div style="margin-bottom:30px;">
                        <h3 style="font-size:1.1rem; color:#333333; border-bottom:2px solid #dddddd; padding-bottom:5px; margin-bottom:15px; text-transform:uppercase;">Objectifs & Compétences</h3>
                        <ul style="color:#555555; line-height:1.8; font-size:0.95rem; padding-left:20px;">
                            <li>Développement continu des compétences techniques et humaines.</li>
                            <li>Recherche de projets innovants et stimulants.</li>
                            <li>Collaboration active au sein d'une équipe dynamique.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div style="text-align:center; margin-top:50px; padding-top:20px; border-top:1px solid #eeeeee; color:#aaaaaa; font-size:0.8rem;">
                Généré par WorkWave — La plateforme de recrutement nouvelle génération.
            </div>
        </div>
    </div>

    <!-- 100% Reliable Native Browser PDF Export -->
    <style>
    @media print {
        @page { margin: 0; }
        body, html, .dsh-main {
            background: #ffffff !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }
        /* Hide all dashboard UI elements */
        .sidebar, .navbar, .page-header, .dsh-card, .alert {
            display: none !important;
        }
        /* Only show the CV container */
        #hiddenCV {
            display: block !important;
            width: 100%;
            background: #ffffff;
            margin: 0 auto;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    }
    </style>

<?php endif; ?>

<?php
if ($isAdmin) {
    include __DIR__ . '/../layout/dashboard_footer.php';
} else {
    include __DIR__ . '/../layout/pl_dashboard_footer.php';
}
?>
