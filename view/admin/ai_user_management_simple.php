<?php include __DIR__ . '/../layout/dashboard_header.php'; ?>

<div class="ww-admin-ai-section">
  <div class="ww-admin-ai-card">
    <h1>🤖 Simple AI User Management</h1>
    <p class="ww-subtitle">Real user data from your WorkWave database</p>

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

    <!-- User Segmentation -->
    <div class="ww-section">
      <h2>🎯 User Segmentation</h2>
      <div class="ww-segmentation-grid">
        <div class="ww-segment-card">
          <h3>🟢 Active Users</h3>
          <div class="ww-segment-metric" id="activeUsersCount">Loading...</div>
          <div class="ww-segment-detail" id="activeUsersPercent">%</div>
        </div>
        <div class="ww-segment-card">
          <h3>🟡 At-Risk Users</h3>
          <div class="ww-segment-metric" id="atRiskUsersCount">Loading...</div>
          <div class="ww-segment-detail" id="atRiskUsersPercent">%</div>
        </div>
        <div class="ww-segment-card">
          <h3>🔴 Dormant Users</h3>
          <div class="ww-segment-metric" id="dormantUsersCount">Loading...</div>
          <div class="ww-segment-detail" id="dormantUsersPercent">%</div>
        </div>
        <div class="ww-segment-card">
          <h3>🔵 New Users</h3>
          <div class="ww-segment-metric" id="newUsersCount">Loading...</div>
          <div class="ww-segment-detail" id="newUsersPercent">%</div>
        </div>
      </div>
      
      <button class="ww-btn-primary" onclick="loadUserSegments()">Load Real Data</button>
    </div>

    <!-- Quick Stats -->
    <div class="ww-section">
      <h2>📊 Quick Platform Stats</h2>
      <div class="ww-stats-grid">
        <div class="ww-stat-card">
          <h3>Total Users</h3>
          <div class="ww-stat-value" id="totalUsersCount">Loading...</div>
        </div>
        <div class="ww-stat-card">
          <h3>New This Month</h3>
          <div class="ww-stat-value" id="newMonthCount">Loading...</div>
        </div>
        <div class="ww-stat-card">
          <h3>Email Verified</h3>
          <div class="ww-stat-value" id="verifiedCount">Loading...</div>
        </div>
        <div class="ww-stat-card">
          <h3>Profile Complete</h3>
          <div class="ww-stat-value" id="profileCompleteCount">Loading...</div>
        </div>
      </div>
      
      <button class="ww-btn-primary" onclick="loadQuickStats()">Load Stats</button>
    </div>
  </div>
</div>

<style>
.ww-admin-ai-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.ww-admin-ai-card {
    background: #1a1a2e;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    color: #fff;
}

.ww-admin-ai-card h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    text-align: center;
}

.ww-subtitle {
    text-align: center;
    opacity: 0.9;
    margin-bottom: 40px;
    font-size: 1.1rem;
}

.ww-section {
    background: #0f0f1e;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    border: 1px solid rgba(255,255,255,0.1);
}

.ww-section h2 {
    margin-bottom: 20px;
    font-size: 1.5rem;
}

.ww-segmentation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.ww-segment-card {
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    border: 2px solid transparent;
}

.ww-segment-card h3 {
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.ww-segment-metric {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.ww-segment-detail {
    font-size: 1rem;
    opacity: 0.8;
}

.ww-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.ww-stat-card {
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    padding: 20px;
    text-align: center;
}

.ww-stat-card h3 {
    margin-bottom: 10px;
    font-size: 1.1rem;
}

.ww-stat-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: #4ade80;
}

.ww-btn-primary {
    background: linear-gradient(135deg, #4ade80, #22d3ee);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.ww-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.ww-alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.ww-alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #f87171;
}

.ww-alert-success {
    background: rgba(74, 222, 128, 0.1);
    border: 1px solid rgba(74, 222, 128, 0.3);
    color: #16a34a;
}
</style>

<script>
function loadUserSegments() {
    fetch('/workwave/Controller/index.php?action=ai_user_segmentation', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('activeUsersCount').textContent = data.segmentation.active.count;
            document.getElementById('activeUsersPercent').textContent = data.segmentation.active.percentage + '%';
            
            document.getElementById('atRiskUsersCount').textContent = data.segmentation.at_risk.count;
            document.getElementById('atRiskUsersPercent').textContent = data.segmentation.at_risk.percentage + '%';
            
            document.getElementById('dormantUsersCount').textContent = data.segmentation.dormant.count;
            document.getElementById('dormantUsersPercent').textContent = data.segmentation.dormant.percentage + '%';
            
            document.getElementById('newUsersCount').textContent = data.segmentation.new.count;
            document.getElementById('newUsersPercent').textContent = data.segmentation.new.percentage + '%';
        } else {
            alert('Error loading user data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading user data');
    });
}

function loadQuickStats() {
    fetch('/workwave/Controller/index.php?action=ai_journey_mapping', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('totalUsersCount').textContent = data.journey_data.registration_funnel.signups_started;
            document.getElementById('newMonthCount').textContent = data.journey_data.registration_funnel.email_verified;
            document.getElementById('verifiedCount').textContent = data.journey_data.registration_funnel.profile_completed;
            document.getElementById('profileCompleteCount').textContent = data.journey_data.registration_funnel.active_users;
        } else {
            alert('Error loading stats');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading stats');
    });
}

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadUserSegments();
    loadQuickStats();
});
</script>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
