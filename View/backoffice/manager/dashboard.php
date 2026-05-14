<?php $pageTitle = 'Dashboard Manager'; $view = 'manager/dashboard'; require __DIR__ . '/../layout/header.php'; ?>

<?php if (!empty($weather)): ?>
<div class="weather-card">
  <div class="weather-emoji"><?= $weather['icon'] ?></div>
  <div>
    <div class="weather-temp"><?= htmlspecialchars((string)$weather['temperature']) ?>&deg;C
      <span style="font-size:14px;color:var(--muted);font-weight:500;margin-left:8px"><?= htmlspecialchars($weather['label']) ?></span>
    </div>
    <div class="weather-meta">
      <i class="fa fa-map-marker"></i> <?= htmlspecialchars($weather['city']) ?>
      &nbsp;|&nbsp; <i class="fa fa-tint"></i> <?= htmlspecialchars((string)$weather['humidity']) ?>%
      &nbsp;|&nbsp; <i class="fa fa-flag"></i> <?= htmlspecialchars((string)$weather['wind']) ?> km/h
    </div>
  </div>
</div>
<?php endif; ?>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon"><i class="fa fa-book"></i></div>
    <div><div class="stat-val"><?= $nbFormations ?></div><div class="stat-label">Formations</div></div>
  </div>
  <div class="stat-card green">
    <div class="stat-icon"><i class="fa fa-users"></i></div>
    <div><div class="stat-val"><?= $nbParticipants ?></div><div class="stat-label">Participants</div></div>
  </div>
  <div class="stat-card orange">
    <div class="stat-icon"><i class="fa fa-check-square"></i></div>
    <div><div class="stat-val"><?= $nbTaches ?></div><div class="stat-label">Taches</div></div>
  </div>
</div>

<div class="chart-grid-pp">
  <div class="chart-card-pp">
    <h3>Formations par niveau</h3>
    <canvas id="chartNiveau" height="180"></canvas>
  </div>
  <div class="chart-card-pp">
    <h3>Statut des taches (toutes formations)</h3>
    <canvas id="chartStatut" height="180"></canvas>
  </div>
</div>

<div class="app-section-heading">
  <h2><i class="fa fa-book" style="margin-right:8px"></i>Mes formations</h2>
  <a href="index.php?role=manager&action=formation_add" class="btn-app btn-app-primary">
    <i class="fa fa-plus"></i> Nouvelle formation
  </a>
</div>

<?php if (empty($formations)): ?>
<div class="empty-state">
  <i class="fa fa-book"></i>
  <p>Aucune formation pour l'instant. Creez votre premiere formation !</p>
</div>
<?php else: ?>
<?php foreach (array_slice($formations, 0, 5) as $f): ?>
<div class="listing-item">
  <div class="left-image">
    <?php if ($f['image_path']): ?>
      <img src="<?= $base ?>View/public/<?= htmlspecialchars($f['image_path']) ?>" alt="">
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
    </div>
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
<?php endif; ?>

<script>
const niveauData = <?= json_encode($statsNiveau ?? []) ?>;
const statutData = <?= json_encode($statsStatut ?? []) ?>;

new Chart(document.getElementById('chartNiveau'), {
  type: 'doughnut',
  data: {
    labels: ['Debutant','Intermediaire','Avance'],
    datasets: [{
      data: [niveauData.debutant||0, niveauData.intermediaire||0, niveauData.avance||0],
      backgroundColor: ['#00ffcc','#ff8e53','#f5576c'],
      borderColor: '#0a0e27', borderWidth: 3,
    }]
  },
  options: { plugins: { legend: { labels: { color: '#e6ebff' } } } }
});

new Chart(document.getElementById('chartStatut'), {
  type: 'bar',
  data: {
    labels: ['En attente','En cours','Termine'],
    datasets: [{
      label: 'Taches',
      data: [statutData.en_attente||0, statutData.en_cours||0, statutData.termine||0],
      backgroundColor: ['rgba(255,142,83,.7)','rgba(0,204,255,.7)','rgba(0,255,204,.7)'],
      borderRadius: 8,
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: {
      x: { ticks: { color: '#8d99af' }, grid: { color: 'rgba(255,255,255,.05)' } },
      y: { ticks: { color: '#8d99af' }, grid: { color: 'rgba(255,255,255,.05)' }, beginAtZero: true }
    }
  }
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
