<?php include __DIR__ . '/../layout/pl_header.php'; ?>

<div class="ww-interview-section">
  <div class="ww-interview-card">
    <h1>Planification d'Entretien</h1>
    <p class="ww-subtitle">Choisissez les créneaux disponibles pour votre entretien</p>

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

    <!-- Interview Details -->
    <div class="ww-interview-details">
      <div class="ww-job-info">
        <h3>📋 Poste: Développeur PHP Senior</h3>
        <p><strong>Entreprise:</strong> Tech Solutions Tunisia</p>
        <p><strong>Type:</strong> Entretien technique (30 min)</p>
        <p><strong>Format:</strong> Visioconférence</p>
      </div>
    </div>

    <!-- Calendar Integration -->
    <div class="ww-calendar-section">
      <h3>📅 Sélectionnez une date</h3>
      <div class="ww-calendar-container">
        <div class="ww-month-navigation">
            <button id="prevMonth" class="ww-nav-btn">‹</button>
            <span id="currentMonth">Décembre 2026</span>
            <button id="nextMonth" class="ww-nav-btn">›</button>
        </div>
        <div class="ww-calendar-grid" id="calendarGrid">
            <!-- Calendar will be generated here -->
        </div>
      </div>
    </div>

    <!-- Time Slots -->
    <div class="ww-time-slots-section">
      <h3>🕐 Créneaux disponibles</h3>
      <div class="ww-time-slots-grid" id="timeSlots">
        <!-- Time slots will be loaded here -->
      </div>
    </div>

    <!-- Interview Preferences -->
    <div class="ww-preferences-section">
      <h3>⚙️ Préférences d'entretien</h3>
      <form id="interviewForm" class="ww-interview-form">
        <div class="ww-form-group">
          <label>Plateforme de visioconférence</label>
          <select name="platform" required>
            <option value="">Choisissez une plateforme</option>
            <option value="zoom">Zoom</option>
            <option value="teams">Microsoft Teams</option>
            <option value="meet">Google Meet</option>
            <option value="skype">Skype</option>
            <option value="phone">Appel téléphonique</option>
          </select>
        </div>

        <div class="ww-form-group">
          <label>Langue de l'entretien</label>
          <select name="language" required>
            <option value="francais">Français</option>
            <option value="anglais">Anglais</option>
            <option value="arabe">Arabe</option>
          </select>
        </div>

        <div class="ww-form-group">
          <label>Notes additionnelles</label>
          <textarea name="notes" rows="3" placeholder="Disponibilités particulières, questions, etc."></textarea>
        </div>

        <div class="ww-form-actions">
          <button type="submit" class="ww-btn-primary">Confirmer l'entretien</button>
          <button type="button" class="ww-btn-secondary">Ajouter au calendrier</button>
        </div>
      </form>
    </div>

    <!-- Calendar Export Options -->
    <div class="ww-export-section">
      <h3>📲 Synchronisation</h3>
      <div class="ww-sync-options">
        <button class="ww-sync-btn google-calendar">
          📅 Ajouter à Google Calendar
        </button>
        <button class="ww-sync-btn outlook">
          📧 Ajouter à Outlook
        </button>
        <button class="ww-sync-btn apple">
          🍎 Ajouter à Apple Calendar
        </button>
      </div>
    </div>
  </div>
</div>

<style>
.ww-interview-section {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.ww-interview-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.ww-interview-details {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    border-left: 4px solid #f97316;
}

.ww-job-info h3 {
    margin-bottom: 15px;
    color: #333;
}

.ww-job-info p {
    margin: 8px 0;
    color: #666;
}

.ww-calendar-section,
.ww-time-slots-section,
.ww-preferences-section,
.ww-export-section {
    margin-bottom: 30px;
}

.ww-calendar-section h3,
.ww-time-slots-section h3,
.ww-preferences-section h3,
.ww-export-section h3 {
    margin-bottom: 20px;
    color: #333;
}

.ww-calendar-container {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
}

.ww-month-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.ww-nav-btn {
    background: #f97316;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    font-size: 18px;
}

.ww-calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}

.ww-calendar-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e1e5e9;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.ww-calendar-day:hover {
    background: #f0f9ff;
    border-color: #0369a1;
}

.ww-calendar-day.selected {
    background: #f97316;
    color: white;
    border-color: #f97316;
}

.ww-calendar-day.disabled {
    color: #ccc;
    cursor: not-allowed;
    background: #f8f9fa;
}

.ww-time-slots-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px;
}

.ww-time-slot {
    padding: 15px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.ww-time-slot:hover {
    border-color: #f97316;
    background: #fff5f0;
}

.ww-time-slot.selected {
    border-color: #f97316;
    background: #f97316;
    color: white;
}

.ww-time-slot.disabled {
    color: #ccc;
    cursor: not-allowed;
    background: #f8f9fa;
}

.ww-interview-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ww-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ww-form-group label {
    font-weight: 600;
    color: #333;
}

.ww-form-group select,
.ww-form-group textarea {
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.ww-form-group select:focus,
.ww-form-group textarea:focus {
    outline: none;
    border-color: #f97316;
}

.ww-form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.ww-sync-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.ww-sync-btn {
    padding: 15px 20px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
}

.ww-sync-btn:hover {
    border-color: #f97316;
    background: #fff5f0;
}

.ww-sync-btn.google-calendar:hover {
    border-color: #4285f4;
    background: #f0f7ff;
}

.ww-sync-btn.outlook:hover {
    border-color: #0078d4;
    background: #f0f9ff;
}

.ww-sync-btn.apple:hover {
    border-color: #000;
    background: #f8f8f8;
}

@media (max-width: 768px) {
    .ww-calendar-grid {
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }
    
    .ww-time-slots-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .ww-sync-options {
        grid-template-columns: 1fr;
    }
    
    .ww-form-actions {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    let selectedDate = null;
    let selectedTime = null;

    // Calendar functionality
    function generateCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Update month display
        const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                          'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;
        
        // Generate calendar days
        const calendarGrid = document.getElementById('calendarGrid');
        calendarGrid.innerHTML = '';
        
        // Add empty cells for days before month starts
        for (let i = 0; i < firstDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'ww-calendar-day disabled';
            calendarGrid.appendChild(emptyDay);
        }
        
        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'ww-calendar-day';
            dayElement.textContent = day;
            
            // Disable past dates
            const dateToCheck = new Date(year, month, day);
            if (dateToCheck < new Date().setHours(0,0,0,0)) {
                dayElement.classList.add('disabled');
            } else {
                dayElement.addEventListener('click', function() {
                    selectDate(year, month, day, this);
                });
            }
            
            calendarGrid.appendChild(dayElement);
        }
    }

    function selectDate(year, month, day, element) {
        // Remove previous selection
        document.querySelectorAll('.ww-calendar-day.selected').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Add selection to clicked date
        element.classList.add('selected');
        selectedDate = new Date(year, month, day);
        
        // Load time slots for selected date
        loadTimeSlots();
    }

    function loadTimeSlots() {
        const timeSlotsContainer = document.getElementById('timeSlots');
        const timeSlots = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'
        ];
        
        timeSlotsContainer.innerHTML = timeSlots.map(time => `
            <div class="ww-time-slot" onclick="selectTime('${time}', this)">
                ${time}
            </div>
        `).join('');
    }

    window.selectTime = function(time, element) {
        // Remove previous selection
        document.querySelectorAll('.ww-time-slot.selected').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Add selection to clicked time slot
        element.classList.add('selected');
        selectedTime = time;
    };

    // Navigation
    document.getElementById('prevMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar();
    });

    // Form submission
    document.getElementById('interviewForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!selectedDate || !selectedTime) {
            alert('Veuillez sélectionner une date et un créneau horaire');
            return;
        }
        
        // Here you would normally send the data to the server
        const formData = new FormData(this);
        formData.append('date', selectedDate.toISOString());
        formData.append('time', selectedTime);
        
        // Simulate success
        const successDiv = document.createElement('div');
        successDiv.className = 'ww-alert ww-alert-success';
        successDiv.innerHTML = 'Entretien planifié avec succès! Vous recevrez une confirmation par email.';
        
        this.parentNode.insertBefore(successDiv, this);
        
        // Reset form
        this.reset();
        selectedDate = null;
        selectedTime = null;
        document.querySelectorAll('.ww-calendar-day.selected, .ww-time-slot.selected').forEach(el => {
            el.classList.remove('selected');
        });
    });

    // Calendar export buttons
    document.querySelectorAll('.ww-sync-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!selectedDate || !selectedTime) {
                alert('Veuillez d\'abord sélectionner une date et un heure');
                return;
            }
            
            // Simulate calendar export
            alert(`Ajout à ${this.textContent.split(' ')[2]} simulé. Dans un vrai projet, cela générerait un fichier .ics ou ouvrirait l'API du calendrier.`);
        });
    });

    // Initialize calendar
    generateCalendar();
});
</script>

<?php include __DIR__ . '/../layout/pl_footer.php'; ?>
