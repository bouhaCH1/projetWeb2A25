<?php $pageTitle = 'Mes taches'; $view = 'client/taches'; require __DIR__ . '/../layout/header.php'; ?>

<?php if ($formation): ?>
<div class="app-breadcrumb">
  <a href="index.php?role=client&action=formations"><i class="fa fa-book"></i> Formations</a>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span><?= htmlspecialchars($formation['titre']) ?></span>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span>Taches</span>
</div>
<?php endif; ?>

<div class="app-section-heading">
  <h2><i class="fa fa-check-square" style="margin-right:8px"></i>
    <?= $formation ? 'Taches : '.htmlspecialchars($formation['titre']) : 'Toutes mes taches' ?>
  </h2>
  <?php if (!$formation): ?>
  <a href="index.php?role=client&action=formations" class="btn-app btn-app-outline btn-app-sm">
    <i class="fa fa-book"></i> Mes formations
  </a>
  <?php endif; ?>
</div>

<div class="filter-chips">
  <span class="chip active" data-filter="all">Tous</span>
  <span class="chip" data-filter="en_attente">En attente</span>
  <span class="chip" data-filter="en_cours">En cours</span>
  <span class="chip" data-filter="termine">Termine</span>
</div>

<?php if (empty($taches)): ?>
<div class="empty-state">
  <i class="fa fa-check-square"></i>
  <p>Aucune tache pour le moment.</p>
</div>
<?php else: ?>
<?php foreach ($taches as $t): ?>
<div class="tache-block" data-statut="<?= $t['mon_statut'] ?>">
  <div class="tache-block-header">
    <div>
      <h4><?= htmlspecialchars($t['titre']) ?></h4>
      <div class="meta">
        <span><i class="fa fa-book"></i> <?= htmlspecialchars($t['formation_titre']) ?></span>
        <span><i class="fa fa-clock-o"></i> <?= $t['duree'] ?>h</span>
        <span><i class="fa fa-calendar"></i> <?= $t['date_debut'] ?> &rarr; <?= $t['date_fin'] ?></span>
      </div>
    </div>
    <span class="status-badge status-<?= $t['mon_statut'] ?>"><?= Tache::STATUTS[$t['mon_statut']] ?></span>
  </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<script>
document.querySelectorAll('.chip').forEach(function(chip) {
    chip.addEventListener('click', function() {
        document.querySelectorAll('.chip').forEach(function(c){ c.classList.remove('active'); });
        this.classList.add('active');
        var filter = this.dataset.filter;
        document.querySelectorAll('.tache-block').forEach(function(block) {
            block.style.display = (filter === 'all' || block.dataset.statut === filter) ? 'block' : 'none';
        });
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
