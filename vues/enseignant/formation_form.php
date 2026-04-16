<?php $pageTitle = $edit ? 'Modifier formation' : 'Nouvelle formation'; require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1><?= $edit ? 'Modifier la formation' : 'Nouvelle formation' ?></h1>
    <a href="index.php?role=enseignant&action=formations" class="btn btn-outline">&larr; Retour</a>
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

    <form method="POST" action="index.php?role=enseignant&action=<?= $edit ? 'formation_edit&id='.(int)$formation_id : 'formation_add' ?>" novalidate>

        <div class="form-group">
            <label for="titre">Titre <span class="required">*</span></label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($titre) ?>" placeholder="Ex: PHP Avance, HTML et CSS...">
            <span class="field-hint">Nom de la formation affiché aux etudiants</span>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" placeholder="Objectifs, contenu, prerequis..."><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="lieu">Lieu</label>
                <input type="text" id="lieu" name="lieu" value="<?= htmlspecialchars($lieu) ?>" placeholder="Ex: Salle 101, En ligne...">
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <select id="niveau" name="niveau">
                    <?php foreach (Formation::NIVEAUX as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($niveau === $key) ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
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

        <div class="form-group" style="max-width:200px">
            <label for="capacite_max">Capacite maximale</label>
            <input type="number" id="capacite_max" name="capacite_max" value="<?= htmlspecialchars((string)$capacite_max) ?>" min="0" placeholder="0">
            <span class="field-hint">0 = illimite</span>
        </div>

        <div class="form-actions">
            <a href="index.php?role=enseignant&action=formations" class="btn btn-outline">Annuler</a>
            <button type="submit" class="btn btn-primary"><?= $edit ? 'Mettre a jour' : 'Creer la formation' ?></button>
        </div>

    </form>
</div>

</main></body></html>
