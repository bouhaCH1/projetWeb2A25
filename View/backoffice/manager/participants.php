<?php $pageTitle = 'Participants — ' . ($formation['titre'] ?? ''); $view = 'manager/participants'; require __DIR__ . '/../layout/header.php'; ?>

<div class="app-breadcrumb">
  <a href="Controller/index.php?role=manager&action=formations"><i class="fa fa-book"></i> Formations</a>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span><?= htmlspecialchars($formation['titre'] ?? '') ?></span>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span>Participants</span>
</div>

<div class="two-col-layout">
  <div>
    <div class="app-table-wrap">
      <div class="app-table-head">
        <h3><i class="fa fa-users" style="margin-right:6px"></i> Participants (<?= count($participants) ?>)</h3>
      </div>
      <?php if (empty($participants)): ?>
      <div class="empty-state" style="padding:40px">
        <i class="fa fa-user-times"></i>
        <p>Aucun participant inscrit.</p>
      </div>
      <?php else: ?>
      <div class="app-table">
        <table>
          <thead>
            <tr><th>Nom</th><th>Email</th><th>Inscrit le</th><th></th></tr>
          </thead>
          <tbody>
          <?php foreach ($participants as $p): ?>
          <tr>
            <td><strong><?= htmlspecialchars($p['prenom'].' '.$p['nom']) ?></strong></td>
            <td><?= htmlspecialchars($p['email'] ?? '') ?></td>
            <td><?= date('d/m/Y', strtotime($p['date_inscription'])) ?></td>
            <td>
              <a href="Controller/index.php?role=manager&action=participant_remove&id=<?= $p['id'] ?>&formation_id=<?= $formationId ?>"
                 class="btn-app btn-app-danger btn-app-sm" onclick="return confirm('Retirer ce participant ?')">
                <i class="fa fa-user-times"></i> Retirer
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <div>
    <div class="form-card" style="max-width:100%">
      <h3><i class="fa fa-user-plus" style="margin-right:8px"></i>Ajouter un participant</h3>
      <form method="POST" action="Controller/index.php?role=manager&action=participant_add&formation_id=<?= $formationId ?>">
        <div class="role-toggle" style="margin-bottom:16px">
          <input type="radio" name="type" id="type_id" value="id" checked>
          <label for="type_id">Client existant</label>
          <input type="radio" name="type" id="type_new" value="new">
          <label for="type_new">Nouveau client</label>
        </div>
        <div id="panelId">
          <div class="form-field">
            <label>Choisir un client</label>
            <select name="client_id">
              <option value="">-- Selectionner --</option>
              <?php foreach ($allClients as $c): ?>
              <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['prenom'].' '.$c['nom']) ?> (<?= htmlspecialchars($c['email']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div id="panelNew" style="display:none">
          <div class="form-row-2">
            <div class="form-field"><label>Nom *</label><input type="text" name="nom" placeholder="NOM"></div>
            <div class="form-field"><label>Prenom *</label><input type="text" name="prenom" placeholder="Prenom"></div>
          </div>
          <div class="form-field"><label>Email *</label><input type="email" name="email" placeholder="client@example.com"></div>
          <div class="form-field"><label>Mot de passe *</label><input type="password" name="password" placeholder="Min. 6 caracteres"></div>
        </div>
        <button type="submit" class="btn-app btn-app-primary btn-app-full">
          <i class="fa fa-user-plus"></i> Ajouter
        </button>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('input[name=type]').forEach(function(r){
    r.addEventListener('change', function(){
        document.getElementById('panelId').style.display  = this.value === 'id'  ? 'block' : 'none';
        document.getElementById('panelNew').style.display = this.value === 'new' ? 'block' : 'none';
    });
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
