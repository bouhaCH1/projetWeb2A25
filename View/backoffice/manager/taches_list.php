<?php $pageTitle = 'Taches — ' . ($formation['titre'] ?? ''); $view = 'manager/taches_list'; require __DIR__ . '/../layout/header.php'; ?>

<div class="app-breadcrumb">
  <a href="index.php?role=manager&action=formations"><i class="fa fa-book"></i> Formations</a>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span><?= htmlspecialchars($formation['titre'] ?? '') ?></span>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span>Taches</span>
</div>

<div class="app-section-heading">
  <h2><i class="fa fa-check-square" style="margin-right:8px"></i>Taches de la formation</h2>
  <a href="index.php?role=manager&action=tache_add&formation_id=<?= $formationId ?>" class="btn-app btn-app-primary">
    <i class="fa fa-plus"></i> Ajouter une tache
  </a>
</div>

<?php if (empty($taches)): ?>
<div class="empty-state">
  <i class="fa fa-check-square"></i>
  <p>Aucune tache pour cette formation.</p>
</div>
<?php else: ?>
<div class="app-table-wrap" style="margin-bottom:30px">
  <div class="app-table-head">
    <h3><i class="fa fa-table" style="margin-right:6px"></i> Matrice des statuts</h3>
  </div>
  <div class="matrix-wrap">
    <div class="app-table">
      <table class="matrix-table">
        <thead>
          <tr>
            <th>Client</th>
            <?php foreach ($taches as $t): ?><th><?= htmlspecialchars($t['titre']) ?></th><?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
        <?php
        $clients = [];
        foreach ($taches as $t) { foreach ($t['statuts'] as $s) { $clients[$s['id']] = $s['prenom'].' '.$s['nom']; } }
        foreach ($clients as $cid => $cname):
        ?>
        <tr>
          <td class="matrix-name"><?= htmlspecialchars($cname) ?></td>
          <?php foreach ($taches as $t): $statut = 'en_attente'; foreach ($t['statuts'] as $s) { if ($s['id'] == $cid) { $statut = $s['statut']; break; } } ?>
          <td class="matrix-cell"><span class="status-badge status-<?= $statut ?>"><?= Tache::STATUTS[$statut] ?></span></td>
          <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
