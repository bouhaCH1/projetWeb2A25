<?php $pageTitle = 'Tableau de bord'; $view = 'client/dashboard'; require __DIR__ . '/../layout/header.php'; ?>

<?php
$termine = count(array_filter($mesTaches, fn($t) => $t['mon_statut'] === 'termine'));
?>

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

<div class="chart-grid-pp">
  <div class="chart-card-pp">
    <h3>Mes taches par statut</h3>
    <canvas id="chartMesStatuts" height="160"></canvas>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon"><i class="fa fa-book"></i></div>
    <div><div class="stat-val"><?= count($mesFormations) ?></div><div class="stat-label">Mes formations</div></div>
  </div>
  <div class="stat-card green">
    <div class="stat-icon"><i class="fa fa-th"></i></div>
    <div><div class="stat-val"><?= count($touteFormations) ?></div><div class="stat-label">Formations disponibles</div></div>
  </div>
  <div class="stat-card orange">
    <div class="stat-icon"><i class="fa fa-check-square"></i></div>
    <div><div class="stat-val"><?= count($mesTaches) ?></div><div class="stat-label">Mes taches</div></div>
  </div>
  <div class="stat-card red">
    <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
    <div><div class="stat-val"><?= $termine ?></div><div class="stat-label">Taches terminees</div></div>
  </div>
</div>

<script>
(function() {
  var taches = <?= json_encode($mesTaches ?? []) ?>;
  var counts = { en_attente: 0, en_cours: 0, termine: 0 };
  taches.forEach(function (t) { if (counts[t.mon_statut] !== undefined) counts[t.mon_statut]++; });
  new Chart(document.getElementById('chartMesStatuts'), {
    type: 'pie',
    data: {
      labels: ['En attente','En cours','Termine'],
      datasets: [{
        data: [counts.en_attente, counts.en_cours, counts.termine],
        backgroundColor: ['#ff8e53','#00ccff','#00ffcc'],
        borderColor: '#0a0e27', borderWidth: 3,
      }]
    },
    options: { plugins: { legend: { labels: { color: '#e6ebff' } } } }
  });
})();
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
