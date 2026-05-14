<?php $pageTitle = 'Formations disponibles'; $view = 'client/formations_list'; require __DIR__ . '/../layout/header.php'; ?>

<div class="app-section-heading">
  <h2><i class="fa fa-book" style="margin-right:8px"></i>Toutes les formations</h2>
  <span style="font-size:13px;color:#8d99af"><?= count($touteFormations) ?> formation(s)</span>
</div>

<?php $filters = $filters ?? ['q'=>'','niveau'=>'','lieu'=>'']; ?>
<form method="GET" action="index.php" class="form-card" style="margin-bottom:20px;padding:16px">
  <input type="hidden" name="role" value="client">
  <input type="hidden" name="action" value="formations">
  <div class="form-row-2" style="margin-bottom:10px">
    <div class="form-field">
      <label>Recherche</label>
      <input type="text" name="q" value="<?= htmlspecialchars($filters['q'] ?? '') ?>" placeholder="Titre, description, lieu...">
    </div>
    <div class="form-field">
      <label>Lieu</label>
      <input type="text" name="lieu" value="<?= htmlspecialchars($filters['lieu'] ?? '') ?>" placeholder="Ex: Tunis">
    </div>
  </div>
  <div class="form-row-2">
    <div class="form-field">
      <label>Niveau</label>
      <select name="niveau">
        <option value="">Tous</option>
        <?php foreach (Formation::NIVEAUX as $key => $label): ?>
          <option value="<?= $key ?>" <?= (($filters['niveau'] ?? '') === $key) ? 'selected' : '' ?>><?= $label ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-field" style="display:flex;align-items:flex-end;gap:10px">
      <button class="btn-app btn-app-primary" type="submit"><i class="fa fa-search"></i> Rechercher</button>
      <a class="btn-app btn-app-gray" href="index.php?role=client&action=formations"><i class="fa fa-refresh"></i> Reinitialiser</a>
    </div>
  </div>
</form>

<?php if (empty($touteFormations)): ?>
<div class="empty-state">
  <i class="fa fa-book"></i>
  <p>Aucune formation disponible pour le moment.</p>
</div>
<?php else: ?>
<?php foreach ($touteFormations as $f):
    $inscrit = in_array($f['id'], $mesIds);
?>
<div class="listing-item">
  <div class="left-image">
    <?php if ($f['image_path']): ?>
      <img src="<?= $base ?>vues/public/<?= htmlspecialchars($f['image_path']) ?>" alt="">
    <?php else: ?>
      <i class="fa fa-book placeholder-icon"></i>
    <?php endif; ?>
    <span class="niveau-badge badge-<?= $f['niveau'] ?>"><?= Formation::NIVEAUX[$f['niveau']] ?></span>
    <?php if ($inscrit): ?>
    <span style="position:absolute;top:50px;right:10px;background:#28a745;color:#fff;border-radius:20px;padding:3px 9px;font-size:10px;font-weight:700">
      <i class="fa fa-check"></i> Inscrit
    </span>
    <?php endif; ?>
  </div>
  <div class="right-content">
    <h4><?= htmlspecialchars($f['titre']) ?></h4>
    <p class="desc"><?= htmlspecialchars($f['description'] ?? '') ?></p>
    <div class="meta-row">
      <span class="meta-item"><i class="fa fa-user"></i><?= htmlspecialchars($f['mgr_prenom'].' '.$f['mgr_nom']) ?></span>
      <?php if ($f['lieu']): ?>
      <span class="meta-item"><i class="fa fa-map-marker"></i><?= htmlspecialchars($f['lieu']) ?></span>
      <?php endif; ?>
      <span class="meta-item"><i class="fa fa-calendar"></i><?= $f['date_debut'] ?> &rarr; <?= $f['date_fin'] ?></span>
    </div>
    <?php if ($f['video_url']): ?>
    <div class="video-embed"><video src="<?= $base ?>vues/public/<?= htmlspecialchars($f['video_url']) ?>" controls style="max-width:100%;border-radius:7px"></video></div>
    <?php endif; ?>
    <div class="listing-stats">
      <span class="listing-stat"><i class="fa fa-users"></i> <?= $f['nb_participants'] ?></span>
      <span class="listing-stat"><i class="fa fa-check-square"></i> <?= $f['nb_taches'] ?> taches</span>
    </div>
    <div class="actions">
      <?php if ($inscrit): ?>
      <a href="index.php?role=client&action=taches&formation_id=<?= $f['id'] ?>" class="btn-app btn-app-primary btn-app-sm">
        <i class="fa fa-check-square"></i> Mes taches
      </a>
      <a href="index.php?role=client&action=quitter&formation_id=<?= $f['id'] ?>" class="btn-app btn-app-danger btn-app-sm btn-app-icon"
         onclick="return confirm('Quitter cette formation ?')" title="Quitter">
        <i class="fa fa-sign-out"></i>
      </a>
      <?php else: ?>
      <a href="index.php?role=client&action=participer&formation_id=<?= $f['id'] ?>" class="btn-app btn-app-success btn-app-sm">
        <i class="fa fa-user-plus"></i> S'inscrire
      </a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
