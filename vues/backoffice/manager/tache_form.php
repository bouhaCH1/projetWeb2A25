<?php
$pageTitle = ($edit ?? false) ? 'Modifier la tache' : 'Nouvelle tache';
$view = 'manager/tache_form';
require __DIR__ . '/../layout/header.php';
?>

<div class="app-breadcrumb">
  <a href="index.php?role=manager&action=formations"><i class="fa fa-book"></i> Formations</a>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <a href="index.php?role=manager&action=taches&formation_id=<?= $formationId ?>"><?= htmlspecialchars($formation['titre'] ?? '') ?></a>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span><?= ($edit ?? false) ? 'Modifier la tache' : 'Nouvelle tache' ?></span>
</div>

<div class="form-card">
  <h3><i class="fa fa-<?= ($edit??false)?'pencil':'plus-circle' ?>" style="margin-right:8px"></i>
    <?= ($edit ?? false) ? 'Modifier la tache' : 'Creer une tache' ?>
  </h3>

  <form method="POST" enctype="multipart/form-data"
        action="index.php?role=manager&action=<?= ($edit??false) ? 'tache_edit&id='.($tache_id??0) : 'tache_add&formation_id='.$formationId ?>">
    <div class="form-row-2">
      <div class="form-field">
        <label>Titre *</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($titre ?? '') ?>" required placeholder="Titre de la tache">
      </div>
      <div class="form-field">
        <label>Duree (heures) *</label>
        <input type="number" name="duree" value="<?= htmlspecialchars($duree ?? '') ?>" min="1" required placeholder="Ex: 3">
      </div>
    </div>

    <div class="form-field">
      <label>Description</label>
      <textarea name="description" rows="4" placeholder="Decrivez la tache..."><?= htmlspecialchars($description ?? '') ?></textarea>
    </div>

    <div class="form-row-2">
      <div class="form-field">
        <label>Date de debut *</label>
        <input type="date" name="date_debut" value="<?= htmlspecialchars($dateDebut ?? '') ?>" required>
      </div>
      <div class="form-field">
        <label>Date de fin *</label>
        <input type="date" name="date_fin" value="<?= htmlspecialchars($dateFin ?? '') ?>" required>
      </div>
    </div>

    <div class="form-section-title"><i class="fa fa-image"></i> Medias</div>

    <div class="form-field">
      <label>Image de la tache</label>
      <div class="upload-zone" onclick="document.getElementById('imgFileTache').click()">
        <input type="file" name="image" id="imgFileTache" accept="image/*" onchange="previewImg(this,'tacheImgPrev')">
        <div class="up-icon"><i class="fa fa-cloud-upload"></i></div>
        <p>Cliquer pour uploader (JPG, PNG, WEBP — max 5 Mo)</p>
      </div>
      <?php if (!empty($tache['image_path'])): ?>
      <div class="media-preview-thumb"><img src="<?= $base ?>vues/public/<?= htmlspecialchars($tache['image_path']) ?>" alt="Image actuelle"></div>
      <?php endif; ?>
      <div class="media-preview-thumb" id="tacheImgPrev"></div>
    </div>

    <div class="form-field">
      <label><i class="fa fa-film"></i> Video</label>
      <div class="upload-zone" onclick="document.getElementById('vidFileTache').click()">
        <input type="file" name="video" id="vidFileTache" accept="video/*" onchange="previewVid(this,'vidPrevTache')">
        <div class="up-icon"><i class="fa fa-video-camera"></i></div>
        <p>Cliquer pour uploader une video (MP4, WEBM, MOV — max 100 Mo)</p>
      </div>
      <?php if (!empty($video_path)): ?>
      <div class="media-preview-thumb" style="margin-top:8px">
        <video src="<?= $base ?>vues/public/<?= htmlspecialchars($video_path) ?>" controls style="max-width:100%;max-height:180px;border-radius:7px"></video>
      </div>
      <?php endif; ?>
      <div class="media-preview-thumb" id="vidPrevTache"></div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-app btn-app-primary">
        <i class="fa fa-<?= ($edit??false)?'save':'plus' ?>"></i>
        <?= ($edit ?? false) ? 'Enregistrer' : 'Creer la tache' ?>
      </button>
      <a href="index.php?role=manager&action=taches&formation_id=<?= $formationId ?>" class="btn-app btn-app-gray">
        <i class="fa fa-times"></i> Annuler
      </a>
    </div>
  </form>
</div>

<script>
function previewImg(input, previewId) {
    var prev = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            prev.innerHTML = '<img src="'+e.target.result+'" style="max-height:140px;border-radius:7px;margin-top:8px">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewVid(input, previewId) {
    var prev = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var url = URL.createObjectURL(input.files[0]);
        prev.innerHTML = '<video src="'+url+'" controls style="max-height:180px;border-radius:7px;margin-top:8px;max-width:100%"></video>';
    }
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
