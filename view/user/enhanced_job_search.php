<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-job-search-section">
  <div class="ww-search-card">
    <h1>Recherche Avancée d'Emploi</h1>
    <p class="ww-subtitle">Trouvez l'emploi parfait avec nos filtres intelligents</p>

    <form id="advancedSearchForm" class="ww-search-form">
      <div class="ww-search-row">
        <div class="ww-search-group">
          <label>Mots-clés</label>
          <input type="text" id="keywords" name="keywords" placeholder="ex: PHP, JavaScript, Marketing...">
        </div>
        
        <div class="ww-search-group">
          <label>Localisation</label>
          <div class="ww-location-input">
            <input type="text" id="location" name="location" placeholder="Ville ou région...">
            <button type="button" id="useMyLocation" class="ww-btn-small">📍 Ma position</button>
          </div>
        </div>
      </div>

      <div class="ww-search-row">
        <div class="ww-search-group">
          <label>Salaire minimum (TND/mois)</label>
          <input type="number" id="salary_min" name="salary_min" placeholder="ex: 1500">
        </div>
        
        <div class="ww-search-group">
          <label>Type de contrat</label>
          <select id="contract_type" name="contract_type">
            <option value="">Tous types</option>
            <option value="CDI">CDI</option>
            <option value="CDD">CDD</option>
            <option value="Freelance">Freelance</option>
            <option value="Stage">Stage</option>
          </select>
        </div>
      </div>

      <div class="ww-search-row">
        <div class="ww-search-group">
          <label>Expérience requise</label>
          <select id="experience" name="experience">
            <option value="">Tous niveaux</option>
            <option value="0">Débutant</option>
            <option value="1-2">1-2 ans</option>
            <option value="3-5">3-5 ans</option>
            <option value="5+">5+ ans</option>
          </select>
        </div>
        
        <div class="ww-search-group">
          <label>Télétravail</label>
          <select id="remote" name="remote">
            <option value="">Peu importe</option>
            <option value="full">100% télétravail</option>
            <option value="hybrid">Hybride</option>
            <option value="office">Présentiel</option>
          </select>
        </div>
      </div>

      <div class="ww-search-actions">
        <button type="submit" class="ww-btn-primary">🔍 Rechercher</button>
        <button type="button" id="resetFilters" class="ww-btn-secondary">Réinitialiser</button>
      </div>
    </form>
  </div>

  <div class="ww-search-results">
    <div class="ww-results-header">
      <h3>Résultats de recherche</h3>
      <div class="ww-results-count">
        <span id="resultsCount">0</span> offres trouvées
      </div>
    </div>
    
    <div id="searchResults" class="ww-results-list">
      <!-- Results will be loaded here -->
    </div>
  </div>
</div>

<style>
.ww-job-search-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.ww-search-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.ww-search-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ww-search-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.ww-search-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ww-search-group label {
    font-weight: 600;
    color: #333;
}

.ww-search-group input,
.ww-search-group select {
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.ww-search-group input:focus,
.ww-search-group select:focus {
    outline: none;
    border-color: #f97316;
}

.ww-location-input {
    display: flex;
    gap: 10px;
}

.ww-location-input input {
    flex: 1;
}

.ww-btn-small {
    padding: 12px 16px;
    background: #f97316;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12px;
    white-space: nowrap;
}

.ww-search-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 10px;
}

.ww-results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 0 10px;
}

.ww-results-count {
    color: #666;
    font-weight: 500;
}

.ww-results-list {
    display: grid;
    gap: 20px;
}

.ww-job-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #f97316;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.ww-job-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.ww-job-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 15px;
}

.ww-job-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.ww-job-company {
    color: #666;
    font-size: 14px;
}

.ww-job-salary {
    font-weight: 600;
    color: #f97316;
    font-size: 16px;
}

.ww-job-description {
    color: #555;
    line-height: 1.6;
    margin-bottom: 15px;
}

.ww-job-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.ww-tag {
    background: #f0f9ff;
    color: #0369a1;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}

.ww-job-actions {
    display: flex;
    gap: 10px;
}

.ww-btn-apply {
    background: #f97316;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 500;
}

.ww-btn-save {
    background: transparent;
    color: #f97316;
    padding: 10px 20px;
    border: 2px solid #f97316;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 500;
}

@media (max-width: 768px) {
    .ww-search-row {
        grid-template-columns: 1fr;
    }
    
    .ww-search-actions {
        flex-direction: column;
    }
    
    .ww-results-header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('advancedSearchForm');
    const locationInput = document.getElementById('location');
    const useMyLocationBtn = document.getElementById('useMyLocation');
    const resetBtn = document.getElementById('resetFilters');
    const resultsContainer = document.getElementById('searchResults');
    const resultsCount = document.getElementById('resultsCount');

    // Sample job data (in real app, this would come from API)
    const sampleJobs = [
        {
            id: 1,
            title: 'Développeur PHP Senior',
            company: 'Tech Solutions Tunisia',
            location: 'Tunis',
            salary: '2500-3500 TND',
            type: 'CDI',
            experience: '3-5 ans',
            remote: 'hybrid',
            description: 'Nous recherchons un développeur PHP expérimenté pour rejoindre notre équipe et travailler sur des projets innovants.',
            tags: ['PHP', 'MySQL', 'JavaScript', 'Symfony']
        },
        {
            id: 2,
            title: 'Marketing Digital Manager',
            company: 'Creative Agency',
            location: 'Sousse',
            salary: '1800-2200 TND',
            type: 'CDI',
            experience: '3-5 ans',
            remote: 'hybrid',
            description: 'Manager une équipe marketing et développer des stratégies digitales pour nos clients.',
            tags: ['Marketing', 'SEO', 'Social Media', 'Analytics']
        }
    ];

    // Get user location
    useMyLocationBtn.addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // In real app, you'd reverse geocode coordinates
                locationInput.value = 'Tunis, Tunisie';
            });
        }
    });

    // Search functionality
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });

    function performSearch() {
        // Simulate search with sample data
        displayResults(sampleJobs);
    }

    function displayResults(jobs) {
        resultsCount.textContent = jobs.length;
        
        if (jobs.length === 0) {
            resultsContainer.innerHTML = '<p>Aucune offre trouvée pour vos critères.</p>';
            return;
        }

        resultsContainer.innerHTML = jobs.map(job => `
            <div class="ww-job-card">
                <div class="ww-job-header">
                    <div>
                        <div class="ww-job-title">${job.title}</div>
                        <div class="ww-job-company">${job.company} • ${job.location}</div>
                    </div>
                    <div class="ww-job-salary">${job.salary}</div>
                </div>
                <div class="ww-job-description">${job.description}</div>
                <div class="ww-job-tags">
                    ${job.tags.map(tag => `<span class="ww-tag">${tag}</span>`).join('')}
                </div>
                <div class="ww-job-actions">
                    <a href="#" class="ww-btn-apply">Postuler</a>
                    <a href="#" class="ww-btn-save">Sauvegarder</a>
                </div>
            </div>
        `).join('');
    }

    // Reset filters
    resetBtn.addEventListener('click', function() {
        searchForm.reset();
        resultsContainer.innerHTML = '';
        resultsCount.textContent = '0';
    });

    // Load initial results
    performSearch();
});
</script>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
