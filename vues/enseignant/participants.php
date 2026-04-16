<?php $pageTitle = 'Participants'; require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Participants &mdash; <?= htmlspecialchars($formation['titre']) ?></h1>
    <a href="index.php?role=enseignant&action=formations" class="btn btn-outline">&larr; Formations</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>

<div class="two-col">

    <!-- Liste participants -->
    <div class="section">
        <h2>Inscrits (<?= count($participants) ?>)</h2>
        <?php if (empty($participants)): ?>
            <div class="empty-state"><p>Aucun participant pour l'instant.</p></div>
        <?php else: ?>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr><th>ID</th><th>Nom</th><th>Prenom</th><th>Inscrit le</th><th></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants as $p): ?>
                            <tr>
                                <td><?= (int)$p['etudiant_id'] ?></td>
                                <td><?= htmlspecialchars($p['nom']) ?></td>
                                <td><?= htmlspecialchars($p['prenom']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['date_inscription'])) ?></td>
                                <td>
                                    <a href="index.php?role=enseignant&action=participant_remove&id=<?= $p['id'] ?>&formation_id=<?= $formationId ?>"
                                       class="btn btn-sm btn-delete"
                                       onclick="return confirm('Retirer ce participant ?')">Retirer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Ajouter -->
    <div>

        <div class="card" style="margin-bottom:20px">
            <h3>Ajouter par ID etudiant</h3>
            <form method="POST" action="index.php?role=enseignant&action=participant_add&formation_id=<?= $formationId ?>" novalidate>
                <input type="hidden" name="type" value="id">
                <div class="form-group">
                    <label>Etudiant existant</label>
                    <select name="etudiant_id">
                        <option value="">Selectionner</option>
                        <?php foreach ($allEtudiants as $e): ?>
                            <option value="<?= (int)$e['id'] ?>"><?= htmlspecialchars($e['prenom'].' '.$e['nom']) ?> (ID:<?= $e['id'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

       

    </div>
</div>

</main></body></html>
