<?php
$pageTitle = ($edit ?? false) ? 'Modifier la formation' : 'Nouvelle formation';
$view = 'manager/formation_form';
require __DIR__ . '/../layout/header.php';
?>

<div class="app-breadcrumb">
  <a href="index.php?role=manager&action=formations"><i class="fa fa-book"></i> Formations</a>
  <span class="sep"><i class="fa fa-angle-right"></i></span>
  <span><?= ($edit ?? false) ? 'Modifier' : 'Nouvelle formation' ?></span>
</div>

<div class="form-card">
  <h3><i class="fa fa-<?= ($edit??false)?'pencil':'plus-circle' ?>" style="margin-right:8px"></i>
    <?= ($edit ?? false) ? 'Modifier la formation' : 'Creer une formation' ?>
  </h3>

  <form method="POST" enctype="multipart/form-data"
        action="index.php?role=manager&action=<?= ($edit??false) ? 'formation_edit&id='.($formation_id??0) : 'formation_add' ?>">

    <div class="form-row-2">
      <div class="form-field">
        <label>Titre *</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($titre ?? '') ?>" required placeholder="Titre de la formation">
      </div>
      <div class="form-field">
        <label>Lieu</label>
        <input type="text" name="lieu" value="<?= htmlspecialchars($lieu ?? '') ?>" placeholder="Salle, ville...">
      </div>
    </div>

    <div class="form-field">
      <label>Description
        <button type="button" id="aiBtn" class="btn-app btn-app-success btn-app-sm" style="margin-left:10px">
          <i class="fa fa-magic"></i> Generer avec IA
        </button>
        <span id="aiStatus" style="margin-left:10px;font-size:12px;color:var(--muted)"></span>
      </label>
      <textarea name="description" id="descField" rows="4" placeholder="Decrivez la formation..."><?= htmlspecialchars($description ?? '') ?></textarea>
    </div>

    <script>
    (function () {
      var aiUrl = <?= json_encode(($base ?? '') . 'index.php?role=manager&action=ai_describe', JSON_UNESCAPED_UNICODE) ?>;
      document.getElementById('aiBtn').addEventListener('click', function () {
        var titre  = document.querySelector('input[name="titre"]').value.trim();
        var niveau = document.querySelector('select[name="niveau"]').value;
        var lieu   = document.querySelector('input[name="lieu"]').value.trim();
        var status = document.getElementById('aiStatus');
        var desc   = document.getElementById('descField');
        if (!titre) { status.textContent = 'Saisis dabord un titre.'; return; }
        status.textContent = 'Generation en cours...';
        var fd = new FormData();
        fd.append('titre', titre); fd.append('niveau', niveau); fd.append('lieu', lieu);
        fetch(aiUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
          .then(function (r) { return r.text().then(function (t) { return { ok: r.ok, status: r.status, text: t }; }); })
          .then(function (res) {
            var d;
            try { d = JSON.parse(res.text); } catch (e) {
              var hint = (res.text.indexOf('Connexion') >= 0 || res.text.indexOf('login') >= 0 || res.text.indexOf('Se connecter') >= 0)
                ? 'Session expiree — reconnecte-toi puis reessaie.'
                : ('Reponse non JSON (HTTP ' + res.status + '). Verifie la console PHP / XAMPP.');
              status.textContent = hint;
              return;
            }
            if (d.error) { status.textContent = 'Erreur: ' + d.error; return; }
            desc.value = (d.description || '').trim();
            if (d.ia_error) {
              status.textContent = 'API: ' + d.ia_error;
              return;
            }
            if (d.configured) {
              var src = d.provider === 'gemini' ? 'Gemini' : (d.provider === 'openai' ? 'OpenAI' : 'IA');
              status.textContent = 'Description generee (' + src + ').';
            } else {
              status.textContent = 'Cle API absente (Gemini ou OpenAI) — texte par defaut.';
            }
          })
          .catch(function () { status.textContent = 'Erreur reseau (connexion interrompue).'; });
      });
    })();
    </script>

    <div class="form-row-2">
      <div class="form-field">
        <label>Niveau</label>
        <select name="niveau">
          <?php foreach (Formation::NIVEAUX as $key => $label): ?>
          <option value="<?= $key ?>" <?= ($niveau??'debutant')===$key?'selected':'' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-field">
        <label>Capacite max</label>
        <input type="number" name="capacite_max" value="<?= htmlspecialchars($capacite_max ?? '') ?>" min="0" placeholder="0 = illimite">
        <span class="hint">Laissez 0 pour illimite</span>
      </div>
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
      <label>Image de couverture</label>
      <div class="upload-zone" onclick="document.getElementById('imgFile').click()">
        <input type="file" name="image" id="imgFile" accept="image/*" onchange="previewImg(this,'imgPreview')">
        <div class="up-icon"><i class="fa fa-cloud-upload"></i></div>
        <p>Cliquer pour uploader une image (JPG, PNG, WEBP — max 5 Mo)</p>
      </div>
      <?php if (!empty($formation['image_path'])): ?>
      <div class="media-preview-thumb"><img src="<?= $base ?>vues/public/<?= htmlspecialchars($formation['image_path']) ?>" alt="Image actuelle"></div>
      <?php endif; ?>
      <div class="media-preview-thumb" id="imgPreview"></div>
    </div>

    <div class="form-field">
      <label><i class="fa fa-film"></i> Video</label>
      <div class="upload-zone" onclick="document.getElementById('vidFile').click()">
        <input type="file" name="video" id="vidFile" accept="video/*" onchange="previewVid(this,'vidPreview')">
        <div class="up-icon"><i class="fa fa-video-camera"></i></div>
        <p>Cliquer pour uploader une video (MP4, WEBM, MOV — max 100 Mo)</p>
      </div>
      <?php if (!empty($video_path)): ?>
      <div class="media-preview-thumb" style="margin-top:8px">
        <video src="<?= $base ?>vues/public/<?= htmlspecialchars($video_path) ?>" controls style="max-width:100%;max-height:180px;border-radius:7px"></video>
      </div>
      <?php endif; ?>
      <div class="media-preview-thumb" id="vidPreview"></div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-app btn-app-primary">
        <i class="fa fa-<?= ($edit??false)?'save':'plus' ?>"></i>
        <?= ($edit ?? false) ? 'Enregistrer' : 'Creer la formation' ?>
      </button>
      <a href="index.php?role=manager&action=formations" class="btn-app btn-app-gray">
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
