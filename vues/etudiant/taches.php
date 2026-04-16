<?php
$pageTitle = $formation ? 'Taches — ' . $formation['titre'] : 'Mes taches';
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h1><?= $formation ? 'Taches &mdash; '.htmlspecialchars($formation['titre']) : 'Toutes mes taches' ?></h1>
    <?php if ($formation): ?>
        <a href="index.php?role=etudiant&action=formations" class="btn btn-outline">&larr; Formations</a>
    <?php endif; ?>
</div>

<?php if (empty($taches)): ?>
    <div class="empty-state">
        <p>Aucune tache pour l'instant.</p>
        <?php if (!$formation): ?>
            <a href="index.php?role=etudiant&action=formations" class="btn btn-primary">Rejoindre une formation</a>
        <?php endif; ?>
    </div>
<?php else: ?>

    <div class="filter-bar">
        <button class="filter-btn active" onclick="filtrer('all', this)">Toutes (<?= count($taches) ?>)</button>
        <button class="filter-btn" onclick="filtrer('en_attente', this)">En attente</button>
        <button class="filter-btn" onclick="filtrer('en_cours', this)">En cours</button>
        <button class="filter-btn" onclick="filtrer('termine', this)">Terminees</button>
    </div>

    <div id="tachesContainer">
        <?php foreach ($taches as $t): ?>
            <div class="tache-block" data-statut="<?= $t['mon_statut'] ?>">
                <div class="tache-block-header">
                    <div>
                        <span class="tache-titre"><?= htmlspecialchars($t['titre']) ?></span>
                        <?php if (!$formation): ?>
                            <span class="tache-formation-label"><?= htmlspecialchars($t['formation_titre']) ?></span>
                        <?php endif; ?>
                        <span class="tache-meta-inline">
                            <?= (int)$t['duree'] ?>h &bull;
                            <?= date('d/m/Y', strtotime($t['date_debut'])) ?> &rarr; <?= date('d/m/Y', strtotime($t['date_fin'])) ?>
                        </span>
                        <?php if ($t['description']): ?>
                            <p class="tache-desc"><?= htmlspecialchars($t['description']) ?></p>
                        <?php endif; ?>
                    </div>
                    <!-- Formulaire de mise a jour du statut -->
                    <form method="POST" action="index.php?role=etudiant&action=update_statut" class="statut-form">
                        <input type="hidden" name="tache_id"    value="<?= (int)$t['id'] ?>">
                        <input type="hidden" name="formation_id" value="<?= (int)$formationId ?>">
                        <label class="sr-only" for="statut_<?= $t['id'] ?>">Statut</label>
                        <select name="statut" id="statut_<?= $t['id'] ?>" class="statut-select statut-<?= $t['mon_statut'] ?>" onchange="this.form.submit()">
                            <?php foreach (Tache::STATUTS as $key => $label): ?>
                                <option value="<?= $key ?>" <?= $t['mon_statut'] === $key ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    function filtrer(statut, btn) {
        document.querySelectorAll('.filter-btn').forEach(function(b){ b.classList.remove('active'); });
        btn.classList.add('active');
        document.querySelectorAll('.tache-block').forEach(function(el){
            el.style.display = (statut === 'all' || el.dataset.statut === statut) ? '' : 'none';
        });
    }
    // Mettre a jour la couleur du select apres changement
    document.querySelectorAll('.statut-select').forEach(function(sel){
        sel.addEventListener('change', function(){
            this.className = 'statut-select statut-' + this.value;
        });
    });
    </script>

<?php endif; ?>

</main></body></html>
