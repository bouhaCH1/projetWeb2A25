<?php $pageTitle = 'Formations'; $view = 'manager/formations_list'; require __DIR__ . '/../layout/header.php'; ?>

<div class="app-section-heading">
  <h2><i class="fa fa-book" style="margin-right:8px"></i>Toutes mes formations
    <?php if (isset($paginator)): ?>
      <span style="font-size:13px;color:var(--muted);font-weight:500;margin-left:8px">(<?= $paginator->getTotal() ?> au total)</span>
    <?php endif; ?>
  </h2>
  <a href="index.php?role=manager&action=formation_add" class="btn-app btn-app-primary">
    <i class="fa fa-plus"></i> Nouvelle formation
  </a>
</div>

<?php $filters = $filters ?? ['q'=>'','niveau'=>'','lieu'=>'']; ?>
<form method="GET" action="index.php" class="form-card" style="margin-bottom:20px;padding:16px">
  <input type="hidden" name="role" value="manager">
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
      <a class="btn-app btn-app-gray" href="index.php?role=manager&action=formations"><i class="fa fa-refresh"></i> Reinitialiser</a>
    </div>
  </div>
</form>

<?php if (empty($formations)): ?>
<div class="empty-state">
  <i class="fa fa-book"></i>
  <p>Aucune formation. Commencez par en creer une.</p>
</div>
<?php else: ?>
<?php foreach ($formations as $f): ?>
<div class="listing-item">
  <div class="left-image">
    <?php if ($f['image_path']): ?>
      <img src="<?= $base ?>vues/public/<?= htmlspecialchars($f['image_path']) ?>" alt="">
    <?php else: ?>
      <i class="fa fa-book placeholder-icon"></i>
    <?php endif; ?>
    <span class="niveau-badge badge-<?= $f['niveau'] ?>"><?= Formation::NIVEAUX[$f['niveau']] ?></span>
  </div>
  <div class="right-content">
    <h4><?= htmlspecialchars($f['titre']) ?></h4>
    <p class="desc"><?= htmlspecialchars($f['description'] ?? '') ?></p>
    <div class="meta-row">
      <?php if ($f['lieu']): ?><span class="meta-item"><i class="fa fa-map-marker"></i><?= htmlspecialchars($f['lieu']) ?></span><?php endif; ?>
      <span class="meta-item"><i class="fa fa-calendar"></i><?= $f['date_debut'] ?> &rarr; <?= $f['date_fin'] ?></span>
      <?php if ($f['capacite_max'] > 0): ?><span class="meta-item"><i class="fa fa-users"></i> Max <?= $f['capacite_max'] ?></span><?php endif; ?>
    </div>
    <?php if ($f['video_url']): ?>
    <div class="video-embed"><video src="<?= $base ?>vues/public/<?= htmlspecialchars($f['video_url']) ?>" controls></video></div>
    <?php endif; ?>
    <div class="listing-stats">
      <span class="listing-stat"><i class="fa fa-users"></i> <?= $f['nb_participants'] ?> participants</span>
      <span class="listing-stat"><i class="fa fa-check-square"></i> <?= $f['nb_taches'] ?> taches</span>
    </div>
    <div class="actions">
      <a href="index.php?role=manager&action=taches&formation_id=<?= $f['id'] ?>" class="btn-app btn-app-gray btn-app-sm"><i class="fa fa-check-square"></i> Taches</a>
      <a href="index.php?role=manager&action=participants&formation_id=<?= $f['id'] ?>" class="btn-app btn-app-success btn-app-sm btn-app-icon"><i class="fa fa-users"></i></a>
      <a href="index.php?role=manager&action=formation_edit&id=<?= $f['id'] ?>" class="btn-app btn-app-warning btn-app-sm btn-app-icon"><i class="fa fa-pencil"></i></a>
      <a href="index.php?role=manager&action=formation_delete&id=<?= $f['id'] ?>" class="btn-app btn-app-danger btn-app-sm btn-app-icon" onclick="return confirm('Supprimer ?')"><i class="fa fa-trash"></i></a>
    </div>
  </div>
</div>
<?php endforeach; ?>

<?php if (isset($paginator) && $paginator->getTotalPages() > 1): ?>
<nav class="pagination-pp" aria-label="Pagination">
  <?php
    $base_params = [
      'role'   => 'manager',
      'action' => 'formations',
      'q'      => $filters['q'] ?? '',
      'niveau' => $filters['niveau'] ?? '',
      'lieu'   => $filters['lieu'] ?? '',
    ];
  ?>
  <a href="<?= $paginator->buildUrl(max(1,$paginator->getCurrentPage()-1), $base_params) ?>"
     class="<?= $paginator->hasPrevious() ? '' : 'disabled' ?>"><i class="fa fa-chevron-left"></i></a>
  <?php foreach ($paginator->pages() as $p): ?>
    <?php if ($p === $paginator->getCurrentPage()): ?>
      <span class="active"><?= $p ?></span>
    <?php else: ?>
      <a href="<?= $paginator->buildUrl($p, $base_params) ?>"><?= $p ?></a>
    <?php endif; ?>
  <?php endforeach; ?>
  <a href="<?= $paginator->buildUrl(min($paginator->getTotalPages(),$paginator->getCurrentPage()+1), $base_params) ?>"
     class="<?= $paginator->hasNext() ? '' : 'disabled' ?>"><i class="fa fa-chevron-right"></i></a>
</nav>
<?php endif; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
