<?php
$pageTitle = $edit ? 'Modifier tache' : 'Nouvelle tache';
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
    <h1><?= $edit ? 'Modifier la tache' : 'Nouvelle tache' ?></h1>
    <div>
        <small class="text-muted">Formation : <?= htmlspecialchars($formation['titre']) ?></small>
        <a href="index.php?role=enseignant&action=taches&formation_id=<?= (int)$formationId ?>" class="btn btn-outline">&larr; Retour</a>
    </div>
</div>

<div class="form-container">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!$edit): ?>
        <div class="alert alert-info">
            Lors de la creation, un statut <strong>En attente</strong> sera automatiquement cree pour chaque etudiant inscrit.
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?role=enseignant&action=<?= $edit ? 'tache_edit&id='.(int)$tache_id : 'tache_add&formation_id='.(int)$formationId ?>" novalidate>

        <div class="form-group">
            <label for="titre">Titre de la tache <span class="required">*</span></label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($titre) ?>" placeholder="Ex: Introduction MVC, PDO et MySQL...">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" placeholder="Details de la tache..."><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="duree">Duree (heures) <span class="required">*</span></label>
                <input type="number" id="duree" name="duree" value="<?= htmlspecialchars((string)$duree) ?>" min="1" placeholder="Ex: 3">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date_debut">Date de debut <span class="required">*</span></label>
                <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($dateDebut) ?>">
            </div>
            <div class="form-group">
                <label for="date_fin">Date de fin <span class="required">*</span></label>
                <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($dateFin) ?>">
            </div>
        </div>

        <div class="form-actions">
            <a href="index.php?role=enseignant&action=taches&formation_id=<?= (int)$formationId ?>" class="btn btn-outline">Annuler</a>
            <button type="submit" class="btn btn-primary"><?= $edit ? 'Mettre a jour' : 'Creer la tache' ?></button>
        </div>

    </form>
</div>

</main></body></html>
