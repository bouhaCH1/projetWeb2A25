<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-profile-section">
  <div class="ww-profile-card">
    <h1>Mon Profil Professionnel</h1>
    <p class="ww-subtitle">Gérez vos informations et connectez vos réseaux professionnels</p>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="ww-alert ww-alert-danger">
        <?php foreach ($_SESSION['errors'] as $error): ?>
          <?= htmlspecialchars($error) ?><br>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="ww-alert ww-alert-success">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <div class="ww-profile-content">
      <!-- Basic Profile Section -->
      <div class="ww-profile-section-card">
        <h3>Informations de base</h3>
        <form id="basicProfileForm" class="ww-profile-form">
          <div class="ww-form-row">
            <div class="ww-form-group">
              <label>Nom</label>
              <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? '') ?>">
            </div>
            <div class="ww-form-group">
              <label>Prénom</label>
              <input type="text" name="first_name" value="<?= htmlspecialchars($data['first_name'] ?? '') ?>">
            </div>
          </div>
          
          <div class="ww-form-row">
            <div class="ww-form-group">
              <label>Email</label>
              <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" readonly>
            </div>
            <div class="ww-form-group">
              <label>Téléphone</label>
              <input type="tel" name="phone" value="<?= htmlspecialchars($data['phone'] ?? '') ?>">
            </div>
          </div>

          <div class="ww-form-row">
            <div class="ww-form-group full-width">
              <label>Bio professionnelle</label>
              <textarea name="bio" rows="4" placeholder="Décrivez votre expérience et vos objectifs..."><?= htmlspecialchars($data['bio'] ?? '') ?></textarea>
            </div>
          </div>

          <button type="submit" class="ww-btn-primary">Mettre à jour</button>
        </form>
      </div>

      <!-- LinkedIn Integration Section -->
      <div class="ww-profile-section-card">
        <h3>🔗 Intégration LinkedIn</h3>
        <div class="ww-linkedin-status">
          <?php if (!empty($data['linkedin_headline'])): ?>
            <div class="ww-linked-in-connected">
              <div class="ww-status-indicator connected"></div>
              <div class="ww-status-text">
                <strong>Profil LinkedIn connecté</strong>
                <p><?= htmlspecialchars($data['linkedin_headline']) ?></p>
                <small>Importé le: <?= date('d/m/Y', strtotime($data['linkedin_imported_at'])) ?></small>
              </div>
              <a href="/workwave/Controller/index.php?action=linkedin_import" class="ww-btn-secondary">Mettre à jour</a>
            </div>
          <?php else: ?>
            <div class="ww-linked-in-disconnected">
              <div class="ww-status-indicator disconnected"></div>
              <div class="ww-status-text">
                <strong>Connectez votre profil LinkedIn</strong>
                <p>Importez automatiquement votre expérience et vos compétences</p>
              </div>
              <a href="/workwave/Controller/index.php?action=linkedin_import" class="ww-btn-primary">Connecter LinkedIn</a>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Skills Section -->
      <div class="ww-profile-section-card">
        <h3>🎯 Compétences</h3>
        <div class="ww-skills-container">
          <div class="ww-skills-input">
            <input type="text" id="skillInput" placeholder="Ajouter une compétence...">
            <button type="button" id="addSkillBtn">+</button>
          </div>
          <div class="ww-skills-list" id="skillsList">
            <!-- Skills will be loaded here -->
          </div>
        </div>
      </div>

      <!-- Salary Expectations -->
      <div class="ww-profile-section-card">
        <h3>💰 Prétentions salariales</h3>
        <form class="ww-salary-form">
          <div class="ww-form-row">
            <div class="ww-form-group">
              <label>Salaire minimum (TND/mois)</label>
              <input type="number" name="salary_min" placeholder="ex: 1500" value="<?= htmlspecialchars($data['salary_min'] ?? '') ?>">
            </div>
            <div class="ww-form-group">
              <label>Salaire idéal (TND/mois)</label>
              <input type="number" name="salary_ideal" placeholder="ex: 2500" value="<?= htmlspecialchars($data['salary_ideal'] ?? '') ?>">
            </div>
          </div>
          <div class="ww-form-row">
            <div class="ww-form-group full-width">
              <label>Disponibilité</label>
              <select name="availability">
                <option value="immediate">Immédiate</option>
                <option value="1month">Dans 1 mois</option>
                <option value="3months">Dans 3 mois</option>
                <option value="negotiable">À négocier</option>
              </select>
            </div>
          </div>
          <button type="submit" class="ww-btn-primary">Enregistrer</button>
        </form>
      </div>

      <!-- Job Preferences -->
      <div class="ww-profile-section-card">
        <h3>🔍 Préférences de recherche</h3>
        <form class="ww-preferences-form">
          <div class="ww-form-row">
            <div class="ww-form-group">
              <label>Localisation souhaitée</label>
              <input type="text" name="preferred_location" placeholder="ex: Tunis, Sousse" value="<?= htmlspecialchars($data['preferred_location'] ?? '') ?>">
            </div>
            <div class="ww-form-group">
              <label>Type de contrat</label>
              <select name="contract_type">
                <option value="">Peu importe</option>
                <option value="CDI">CDI</option>
                <option value="CDD">CDD</option>
                <option value="Freelance">Freelance</option>
                <option value="Stage">Stage</option>
              </select>
            </div>
          </div>
          <div class="ww-form-row">
            <div class="ww-form-group">
              <label>Télétravail</label>
              <select name="remote_preference">
                <option value="">Peu importe</option>
                <option value="full">100% télétravail</option>
                <option value="hybrid">Hybride</option>
                <option value="office">Présentiel</option>
              </select>
            </div>
            <div class="ww-form-group">
              <label>Domaine d'activité</label>
              <select name="industry">
                <option value="">Tous domaines</option>
                <option value="tech">Informatique/Tech</option>
                <option value="marketing">Marketing/Communication</option>
                <option value="finance">Finance/Comptabilité</option>
                <option value="hr">Ressources Humaines</option>
                <option value="sales">Commerce/Vente</option>
              </select>
            </div>
          </div>
          <button type="submit" class="ww-btn-primary">Sauvegarder</button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.ww-profile-section {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.ww-profile-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.ww-profile-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.ww-profile-section-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 25px;
    border-left: 4px solid #f97316;
}

.ww-profile-section-card h3 {
    margin-bottom: 20px;
    color: #333;
}

.ww-profile-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ww-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.ww-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ww-form-group.full-width {
    grid-column: 1 / -1;
}

.ww-form-group label {
    font-weight: 600;
    color: #333;
}

.ww-form-group input,
.ww-form-group select,
.ww-form-group textarea {
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.ww-form-group input:focus,
.ww-form-group select:focus,
.ww-form-group textarea:focus {
    outline: none;
    border-color: #f97316;
}

.ww-linkedin-status {
    display: flex;
    align-items: center;
    gap: 20px;
}

.ww-linked-in-connected,
.ww-linked-in-disconnected {
    display: flex;
    align-items: center;
    gap: 15px;
    width: 100%;
}

.ww-status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.ww-status-indicator.connected {
    background: #10b981;
}

.ww-status-indicator.disconnected {
    background: #6b7280;
}

.ww-status-text {
    flex: 1;
}

.ww-status-text strong {
    color: #333;
}

.ww-status-text p {
    color: #666;
    margin: 5px 0;
}

.ww-status-text small {
    color: #999;
}

.ww-skills-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ww-skills-input {
    display: flex;
    gap: 10px;
}

.ww-skills-input input {
    flex: 1;
    padding: 10px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
}

.ww-skills-input button {
    background: #f97316;
    color: white;
    border: none;
    border-radius: 8px;
    width: 40px;
    height: 40px;
    cursor: pointer;
    font-size: 18px;
}

.ww-skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.ww-skill-tag {
    background: #f0f9ff;
    color: #0369a1;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ww-skill-tag .remove-skill {
    cursor: pointer;
    font-weight: bold;
    color: #0369a1;
}

@media (max-width: 768px) {
    .ww-form-row {
        grid-template-columns: 1fr;
    }
    
    .ww-linked-in-connected,
    .ww-linked-in-disconnected {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Skills management
    const skillInput = document.getElementById('skillInput');
    const addSkillBtn = document.getElementById('addSkillBtn');
    const skillsList = document.getElementById('skillsList');
    
    let skills = ['PHP', 'JavaScript', 'MySQL']; // Sample skills
    
    function renderSkills() {
        skillsList.innerHTML = skills.map(skill => `
            <div class="ww-skill-tag">
                ${skill}
                <span class="remove-skill" onclick="removeSkill('${skill}')">×</span>
            </div>
        `).join('');
    }
    
    function addSkill() {
        const skill = skillInput.value.trim();
        if (skill && !skills.includes(skill)) {
            skills.push(skill);
            skillInput.value = '';
            renderSkills();
        }
    }
    
    window.removeSkill = function(skill) {
        skills = skills.filter(s => s !== skill);
        renderSkills();
    };
    
    addSkillBtn.addEventListener('click', addSkill);
    skillInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill();
        }
    });
    
    renderSkills();
});
</script>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
