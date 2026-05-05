<?php include __DIR__ . '/../layout/dashboard_header.php'; ?>

<div class="ww-admin-ai-section">
  <div class="ww-admin-ai-card">
    <h1>🤖 Intelligent User Management AI</h1>
    <p class="ww-subtitle">Advanced AI-powered insights for strategic user management</p>

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

    <!-- AI-Powered User Segmentation -->
    <div class="ww-section">
      <h2>🎯 AI-Powered User Segmentation</h2>
      <div class="ww-segmentation-grid">
        <div class="ww-segment-card active">
          <div class="ww-segment-header">
            <div class="ww-segment-icon">🟢</div>
            <div class="ww-segment-title">Active Users</div>
          </div>
          <div class="ww-segment-metrics">
            <div class="ww-segment-count" id="activeCount">0</div>
            <div class="ww-segment-percentage" id="activePercentage">0%</div>
          </div>
          <div class="ww-segment-details">
            <div class="ww-segment-stat">
              <span>Avg Days Since Login:</span>
              <strong id="activeDaysSinceLogin">0</strong>
            </div>
            <div class="ww-segment-stat">
              <span>Avg Applications:</span>
              <strong id="activeApplications">0</strong>
            </div>
          </div>
          <div class="ww-segment-health">
            <div class="ww-health-bar">
              <div class="ww-health-fill" id="activeHealthBar" style="width: 0%"></div>
            </div>
            <span class="ww-health-label" id="activeHealthLabel">Good</span>
          </div>
        </div>

        <div class="ww-segment-card at-risk">
          <div class="ww-segment-header">
            <div class="ww-segment-icon">🟡</div>
            <div class="ww-segment-title">At-Risk Users</div>
          </div>
          <div class="ww-segment-metrics">
            <div class="ww-segment-count" id="atRiskCount">0</div>
            <div class="ww-segment-percentage" id="atRiskPercentage">0%</div>
          </div>
          <div class="ww-segment-details">
            <div class="ww-segment-stat">
              <span>Avg Days Since Login:</span>
              <strong id="atRiskDaysSinceLogin">0</strong>
            </div>
            <div class="ww-segment-risk-factors">
              <div class="ww-risk-factor">Decreased login frequency</div>
              <div class="ww-risk-factor">Low engagement</div>
            </div>
          </div>
          <div class="ww-segment-health">
            <div class="ww-health-bar">
              <div class="ww-health-fill" id="atRiskHealthBar" style="width: 0%"></div>
            </div>
            <span class="ww-health-label" id="atRiskHealthLabel">Needs Attention</span>
          </div>
        </div>

        <div class="ww-segment-card dormant">
          <div class="ww-segment-header">
            <div class="ww-segment-icon">🔴</div>
            <div class="ww-segment-title">Dormant Users</div>
          </div>
          <div class="ww-segment-metrics">
            <div class="ww-segment-count" id="dormantCount">0</div>
            <div class="ww-segment-percentage" id="dormantPercentage">0%</div>
          </div>
          <div class="ww-segment-details">
            <div class="ww-segment-stat">
              <span>Avg Days Since Login:</span>
              <strong id="dormantDaysSinceLogin">0</strong>
            </div>
            <div class="ww-segment-stat">
              <span>Reactivation Potential:</span>
              <strong id="dormantReactivationPotential">0%</strong>
            </div>
          </div>
          <div class="ww-segment-health">
            <div class="ww-health-bar">
              <div class="ww-health-fill" id="dormantHealthBar" style="width: 0%"></div>
            </div>
            <span class="ww-health-label" id="dormantHealthLabel">Poor</span>
          </div>
        </div>

        <div class="ww-segment-card new">
          <div class="ww-segment-header">
            <div class="ww-segment-icon">🔵</div>
            <div class="ww-segment-title">New Users</div>
          </div>
          <div class="ww-segment-metrics">
            <div class="ww-segment-count" id="newCount">0</div>
            <div class="ww-segment-percentage" id="newPercentage">0%</div>
          </div>
          <div class="ww-segment-details">
            <div class="ww-segment-stat">
              <span>Avg Days Since Registration:</span>
              <strong id="newDaysSinceRegistration">0</strong>
            </div>
            <div class="ww-segment-stat">
              <span>Retention Rate:</span>
              <strong id="newRetentionRate">0%</strong>
            </div>
          </div>
          <div class="ww-segment-health">
            <div class="ww-health-bar">
              <div class="ww-health-fill" id="newHealthBar" style="width: 0%"></div>
            </div>
            <span class="ww-health-label" id="newHealthLabel">Growing</span>
          </div>
        </div>

        <div class="ww-segment-card premium">
          <div class="ww-segment-header">
            <div class="ww-segment-icon">💎</div>
            <div class="ww-segment-title">Premium Users</div>
          </div>
          <div class="ww-segment-metrics">
            <div class="ww-segment-count" id="premiumCount">0</div>
            <div class="ww-segment-percentage" id="premiumPercentage">0%</div>
          </div>
          <div class="ww-segment-details">
            <div class="ww-segment-stat">
              <span>Avg Days Since Login:</span>
              <strong id="premiumDaysSinceLogin">0</strong>
            </div>
            <div class="ww-segment-stat">
              <span>Upgrade Rate:</span>
              <strong id="premiumUpgradeRate">0%</strong>
            </div>
          </div>
          <div class="ww-segment-health">
            <div class="ww-health-bar">
              <div class="ww-health-fill" id="premiumHealthBar" style="width: 0%"></div>
            </div>
            <span class="ww-health-label" id="premiumHealthLabel">Excellent</span>
          </div>
        </div>
      </div>

      <div class="ww-segment-recommendations">
        <h3>📋 AI Recommendations</h3>
        <div id="segmentRecommendations"></div>
      </div>

      <button class="ww-btn-primary" onclick="testButtonClick('segmentation')">Analyze User Segments</button>
    </div>

    <!-- Automated User Journey Mapping -->
    <div class="ww-section">
      <h2>🗺️ Automated User Journey Mapping</h2>
      <div class="ww-journey-container">
        <div class="ww-journey-funnel">
          <h3>Registration Funnel</h3>
          <div class="ww-funnel-steps">
            <div class="ww-funnel-step">
              <div class="ww-step-number">1</div>
              <div class="ww-step-info">
                <div class="ww-step-title">Visitors</div>
                <div class="ww-step-count" id="visitorCount">10,000</div>
              </div>
            </div>
            <div class="ww-funnel-step">
              <div class="ww-step-number">2</div>
              <div class="ww-step-info">
                <div class="ww-step-title">Signups Started</div>
                <div class="ww-step-count" id="signupStartedCount">2,500</div>
              </div>
            </div>
            <div class="ww-funnel-step">
              <div class="ww-step-number">3</div>
              <div class="ww-step-info">
                <div class="ww-step-title">Email Verified</div>
                <div class="ww-step-count" id="emailVerifiedCount">1,800</div>
              </div>
            </div>
            <div class="ww-funnel-step">
              <div class="ww-step-number">4</div>
              <div class="ww-step-info">
                <div class="ww-step-title">Profile Completed</div>
                <div class="ww-step-count" id="profileCompletedCount">1,200</div>
              </div>
            </div>
            <div class="ww-funnel-step">
              <div class="ww-step-number">5</div>
              <div class="ww-step-info">
                <div class="ww-step-title">Active Users</div>
                <div class="ww-step-count" id="activeUsersCount">800</div>
              </div>
            </div>
          </div>
          <div class="ww-funnel-metrics">
            <div class="ww-funnel-metric">
              <span>Overall Conversion Rate:</span>
              <strong id="conversionRate">8.0%</strong>
            </div>
          </div>
        </div>

        <div class="ww-journey-stages">
          <h3>Engagement Journey</h3>
          <div class="ww-journey-timeline">
            <div class="ww-journey-stage">
              <div class="ww-stage-icon">👤</div>
              <div class="ww-stage-info">
                <div class="ww-stage-title">First Login</div>
                <div class="ww-stage-time">Avg: 2 hours</div>
                <div class="ww-stage-completion">85% completion</div>
              </div>
            </div>
            <div class="ww-journey-stage">
              <div class="ww-stage-icon">📝</div>
              <div class="ww-stage-info">
                <div class="ww-stage-title">First Application</div>
                <div class="ww-stage-time">Avg: 1 day</div>
                <div class="ww-stage-completion">60% completion</div>
              </div>
            </div>
            <div class="ww-journey-stage">
              <div class="ww-stage-icon">🎤</div>
              <div class="ww-stage-info">
                <div class="ww-stage-title">First Interview</div>
                <div class="ww-stage-time">Avg: 3 days</div>
                <div class="ww-stage-completion">25% completion</div>
              </div>
            </div>
            <div class="ww-journey-stage">
              <div class="ww-stage-icon">🎉</div>
              <div class="ww-stage-info">
                <div class="ww-stage-title">First Hire</div>
                <div class="ww-stage-time">Avg: 2 weeks</div>
                <div class="ww-stage-completion">15% completion</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="ww-journey-insights">
        <h3>🔍 AI Journey Insights</h3>
        <div id="journeyInsights"></div>
      </div>

      <button class="ww-btn-primary" onclick="testButtonClick('journey')">Map User Journey</button>
    </div>

    <!-- Fraud Detection and Suspicious Activity Alerts -->
    <div class="ww-section">
      <h2>🛡️ Fraud Detection & Security Alerts</h2>
      <div class="ww-security-dashboard">
        <div class="ww-security-overview">
          <div class="ww-risk-summary">
            <h3>Overall Risk Level</h3>
            <div class="ww-risk-indicator" id="overallRiskLevel">
              <div class="ww-risk-circle">
                <div class="ww-risk-value" id="riskValue">LOW</div>
              </div>
            </div>
          </div>

          <div class="ww-security-metrics">
            <div class="ww-metric-row">
              <div class="ww-security-metric">
                <div class="ww-metric-label">Suspicious Activities</div>
                <div class="ww-metric-value" id="suspiciousActivities">0</div>
              </div>
              <div class="ww-security-metric">
                <div class="ww-metric-label">High Risk Users</div>
                <div class="ww-metric-value" id="highRiskUsers">0</div>
              </div>
            </div>
            <div class="ww-metric-row">
              <div class="ww-security-metric">
                <div class="ww-metric-label">Critical Alerts</div>
                <div class="ww-metric-value" id="criticalAlerts">0</div>
              </div>
              <div class="ww-security-metric">
                <div class="ww-metric-label">Fraud Patterns</div>
                <div class="ww-metric-value" id="fraudPatterns">0</div>
              </div>
            </div>
          </div>
        </div>

        <div class="ww-alerts-panel">
          <h3>🚨 Security Alerts</h3>
          <div class="ww-alert-categories">
            <div class="ww-alert-category critical">
              <h4>🔴 Critical Alerts</h4>
              <div id="criticalAlertsList"></div>
            </div>
            <div class="ww-alert-category warning">
              <h4>🟡 Warning Alerts</h4>
              <div id="warningAlertsList"></div>
            </div>
            <div class="ww-alert-category info">
              <h4>🔵 Info Alerts</h4>
              <div id="infoAlertsList"></div>
            </div>
          </div>
        </div>

        <div class="ww-security-actions">
          <h3>⚡ Immediate Actions Required</h3>
          <div id="immediateActions"></div>
        </div>
      </div>

      <button class="ww-btn-primary" onclick="testButtonClick('fraud')">Run Security Analysis</button>
    </div>

    <!-- User Satisfaction Prediction -->
    <div class="ww-section">
      <h2>😊 User Satisfaction Prediction</h2>
      <div class="ww-satisfaction-dashboard">
        <div class="ww-satisfaction-overview">
          <div class="ww-satisfaction-score">
            <h3>Overall Satisfaction</h3>
            <div class="ww-score-circle">
              <div class="ww-score-value" id="satisfactionScore">7.8</div>
              <div class="ww-score-label">out of 10</div>
            </div>
            <div class="ww-satisfaction-trend" id="satisfactionTrend">📈 +0.3</div>
          </div>

          <div class="ww-satisfaction-breakdown">
            <h4>Satisfaction Components</h4>
            <div class="ww-satisfaction-bars">
              <div class="ww-satisfaction-item">
                <span>Platform Usability</span>
                <div class="ww-satisfaction-bar">
                  <div class="ww-satisfaction-fill" id="usabilityBar" style="width: 0%"></div>
                </div>
                <span class="ww-satisfaction-value" id="usabilityValue">8.2</span>
              </div>
              <div class="ww-satisfaction-item">
                <span>Job Matching</span>
                <div class="ww-satisfaction-bar">
                  <div class="ww-satisfaction-fill" id="matchingBar" style="width: 0%"></div>
                </div>
                <span class="ww-satisfaction-value" id="matchingValue">7.5</span>
              </div>
              <div class="ww-satisfaction-item">
                <span>Customer Support</span>
                <div class="ww-satisfaction-bar">
                  <div class="ww-satisfaction-fill" id="supportBar" style="width: 0%"></div>
                </div>
                <span class="ww-satisfaction-value" id="supportValue">8.1</span>
              </div>
              <div class="ww-satisfaction-item">
                <span>Feature Set</span>
                <div class="ww-satisfaction-bar">
                  <div class="ww-satisfaction-fill" id="featuresBar" style="width: 0%"></div>
                </div>
                <span class="ww-satisfaction-value" id="featuresValue">7.3</span>
              </div>
            </div>
          </div>
        </div>

        <div class="ww-satisfaction-analysis">
          <div class="ww-satisfaction-drivers">
            <h4>🎯 Satisfaction Drivers</h4>
            <div id="satisfactionDrivers"></div>
          </div>
          <div class="ww-satisfaction-issues">
            <h4>⚠️ Dissatisfaction Factors</h4>
            <div id="dissatisfactionFactors"></div>
          </div>
        </div>

        <div class="ww-satisfaction-predictions">
          <h4>🔮 Future Predictions</h4>
          <div class="ww-prediction-grid">
            <div class="ww-prediction-item">
              <span>Next Month</span>
              <strong id="nextMonthPrediction">7.9</strong>
            </div>
            <div class="ww-prediction-item">
              <span>Next Quarter</span>
              <strong id="nextQuarterPrediction">8.1</strong>
            </div>
            <div class="ww-prediction-item">
              <span>Next Year</span>
              <strong id="nextYearPrediction">8.4</strong>
            </div>
            <div class="ww-prediction-item">
              <span>Confidence</span>
              <strong id="predictionConfidence">85%</strong>
            </div>
          </div>
        </div>
      </div>

      <button class="ww-btn-primary" onclick="testButtonClick('satisfaction')">Analyze Satisfaction</button>
    </div>

    <!-- Personalized Admin Recommendations -->
    <div class="ww-section">
      <h2>🎯 Personalized Admin Recommendations</h2>
      <div class="ww-recommendations-dashboard">
        <div class="ww-recommendation-categories">
          <div class="ww-recommendation-category">
            <h3>👥 User Engagement</h3>
            <div id="engagementRecommendations"></div>
          </div>
          <div class="ww-recommendation-category">
            <h3>🔄 Retention Strategies</h3>
            <div id="retentionRecommendations"></div>
          </div>
          <div class="ww-recommendation-category">
            <h3>📈 Growth Opportunities</h3>
            <div id="growthRecommendations"></div>
          </div>
          <div class="ww-recommendation-category">
            <h3>🔧 Platform Improvements</h3>
            <div id="platformRecommendations"></div>
          </div>
          <div class="ww-recommendation-category">
            <h3>🤖 Automation Opportunities</h3>
            <div id="automationRecommendations"></div>
          </div>
        </div>

        <div class="ww-priority-actions">
          <h3>⚡ Priority Actions</h3>
          <div class="ww-action-priorities">
            <div class="ww-priority-level critical">
              <h4>🔴 Critical</h4>
              <div id="criticalActions"></div>
            </div>
            <div class="ww-priority-level high">
              <h4>🟡 High</h4>
              <div id="highPriorityActions"></div>
            </div>
            <div class="ww-priority-level medium">
              <h4>🟢 Medium</h4>
              <div id="mediumPriorityActions"></div>
            </div>
          </div>
        </div>

        <div class="ww-impact-analysis">
          <h3>📊 Expected Impact</h3>
          <div class="ww-impact-metrics">
            <div class="ww-impact-item">
              <span>User Retention</span>
              <strong class="ww-impact-positive">+15%</strong>
            </div>
            <div class="ww-impact-item">
              <span>User Satisfaction</span>
              <strong class="ww-impact-positive">+12%</strong>
            </div>
            <div class="ww-impact-item">
              <span>Platform Growth</span>
              <strong class="ww-impact-positive">+20%</strong>
            </div>
            <div class="ww-impact-item">
              <span>Operational Efficiency</span>
              <strong class="ww-impact-positive">+25%</strong>
            </div>
          </div>
        </div>
      </div>

      <button class="ww-btn-primary" onclick="testButtonClick('recommendations')">Get AI Recommendations</button>
    </div>
  </div>
</div>

<style>
.ww-admin-ai-section {
    max-width: 1400px;
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

/* User Segmentation Styles */
.ww-segmentation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ww-segment-card {
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 20px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.ww-segment-card.active {
    border-color: #4ade80;
}

.ww-segment-card.at-risk {
    border-color: #fbbf24;
}

.ww-segment-card.dormant {
    border-color: #ef4444;
}

.ww-segment-card.new {
    border-color: #3b82f6;
}

.ww-segment-card.premium {
    border-color: #8b5cf6;
}

.ww-segment-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.ww-segment-icon {
    font-size: 1.5rem;
}

.ww-segment-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.ww-segment-metrics {
    display: flex;
    align-items: baseline;
    gap: 10px;
    margin-bottom: 15px;
}

.ww-segment-count {
    font-size: 2rem;
    font-weight: bold;
}

.ww-segment-percentage {
    font-size: 1.2rem;
    opacity: 0.8;
}

.ww-segment-details {
    margin-bottom: 15px;
}

.ww-segment-stat {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.ww-risk-factors {
    margin-top: 10px;
}

.ww-risk-factor {
    background: rgba(251, 191, 36, 0.1);
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    margin-bottom: 5px;
}

.ww-segment-health {
    margin-top: 10px;
}

.ww-health-bar {
    height: 6px;
    background: rgba(255,255,255,0.1);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 5px;
}

.ww-health-fill {
    height: 100%;
    background: linear-gradient(90deg, #4ade80, #22d3ee);
    transition: width 1s ease;
}

.ww-health-label {
    font-size: 0.8rem;
    opacity: 0.8;
}

/* Journey Mapping Styles */
.ww-journey-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.ww-funnel-steps {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ww-funnel-step {
    display: flex;
    align-items: center;
    gap: 15px;
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 8px;
}

.ww-step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4ade80, #22d3ee);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.ww-step-title {
    font-weight: 600;
    margin-bottom: 5px;
}

.ww-step-count {
    font-size: 1.2rem;
    font-weight: bold;
    color: #4ade80;
}

.ww-funnel-metrics {
    margin-top: 20px;
    padding: 15px;
    background: rgba(74, 222, 128, 0.1);
    border-radius: 8px;
    text-align: center;
}

.ww-journey-timeline {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ww-journey-stage {
    display: flex;
    align-items: center;
    gap: 15px;
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 8px;
}

.ww-stage-icon {
    font-size: 1.5rem;
}

.ww-stage-title {
    font-weight: 600;
    margin-bottom: 5px;
}

.ww-stage-time {
    font-size: 0.9rem;
    opacity: 0.8;
}

.ww-stage-completion {
    font-size: 0.9rem;
    color: #4ade80;
}

/* Security Dashboard Styles */
.ww-security-dashboard {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.ww-risk-summary {
    text-align: center;
}

.ww-risk-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: conic-gradient(#4ade80 0deg, #4ade80 var(--risk-angle), rgba(255,255,255,0.1) var(--risk-angle));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 20px auto;
}

.ww-risk-value {
    font-size: 1.5rem;
    font-weight: bold;
}

.ww-security-metrics {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.ww-metric-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.ww-security-metric {
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 8px;
    text-align: center;
}

.ww-metric-label {
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 5px;
}

.ww-metric-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4ade80;
}

.ww-alert-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.ww-alert-category {
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    padding: 15px;
}

.ww-alert-category h4 {
    margin-bottom: 15px;
}

.ww-alert-item {
    background: rgba(255,255,255,0.05);
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
    font-size: 0.9rem;
}

/* Satisfaction Dashboard Styles */
.ww-satisfaction-dashboard {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.ww-satisfaction-overview {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.ww-satisfaction-score {
    text-align: center;
}

.ww-score-circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: conic-gradient(#4ade80 0deg, #4ade80 var(--score-angle), rgba(255,255,255,0.1) var(--score-angle));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 20px auto;
}

.ww-score-value {
    font-size: 2.5rem;
    font-weight: bold;
}

.ww-score-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.ww-satisfaction-trend {
    font-size: 1.2rem;
    color: #4ade80;
    margin-top: 10px;
}

.ww-satisfaction-bars {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ww-satisfaction-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.ww-satisfaction-bar {
    flex: 1;
    height: 8px;
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
    overflow: hidden;
}

.ww-satisfaction-fill {
    height: 100%;
    background: linear-gradient(90deg, #4ade80, #22d3ee);
    transition: width 1s ease;
}

.ww-satisfaction-value {
    width: 40px;
    text-align: right;
    font-weight: bold;
}

/* Recommendations Styles */
.ww-recommendation-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ww-recommendation-category {
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    padding: 20px;
}

.ww-recommendation-category h3 {
    margin-bottom: 15px;
    color: #4ade80;
}

.ww-recommendation-item {
    background: rgba(255,255,255,0.05);
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 10px;
    font-size: 0.9rem;
    border-left: 3px solid #4ade80;
}

.ww-action-priorities {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ww-priority-level {
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    padding: 20px;
}

.ww-priority-level h4 {
    margin-bottom: 15px;
}

.ww-priority-level.critical h4 {
    color: #ef4444;
}

.ww-priority-level.high h4 {
    color: #fbbf24;
}

.ww-priority-level.medium h4 {
    color: #4ade80;
}

.ww-impact-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.ww-impact-item {
    background: rgba(255,255,255,0.05);
    padding: 15px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ww-impact-positive {
    color: #4ade80;
    font-weight: bold;
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
}

.ww-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .ww-admin-ai-card {
        padding: 20px;
    }
    
    .ww-segmentation-grid,
    .ww-journey-container,
    .ww-security-dashboard,
    .ww-satisfaction-dashboard {
        grid-template-columns: 1fr;
    }
    
    .ww-recommendation-categories,
    .ww-action-priorities {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Load all AI data on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, attaching event listeners...');
    
    // Attach click listeners to buttons
    const segmentBtn = document.querySelector('button[onclick="loadUserSegmentation()"]');
    const journeyBtn = document.querySelector('button[onclick="loadJourneyMapping()"]');
    const fraudBtn = document.querySelector('button[onclick="loadFraudDetection()"]');
    const satisfactionBtn = document.querySelector('button[onclick="loadSatisfactionPrediction()"]');
    const recommendationsBtn = document.querySelector('button[onclick="loadAdminRecommendations()"]');
    
    if (segmentBtn) {
        segmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Segment button clicked');
            loadUserSegmentation();
        });
    }
    
    if (journeyBtn) {
        journeyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Journey button clicked');
            loadJourneyMapping();
        });
    }
    
    if (fraudBtn) {
        fraudBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Fraud button clicked');
            loadFraudDetection();
        });
    }
    
    if (satisfactionBtn) {
        satisfactionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Satisfaction button clicked');
            loadSatisfactionPrediction();
        });
    }
    
    if (recommendationsBtn) {
        recommendationsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Recommendations button clicked');
            loadAdminRecommendations();
        });
    }
    
    // Auto-load data
    loadUserSegmentation();
    loadJourneyMapping();
    loadFraudDetection();
    loadSatisfactionPrediction();
    loadAdminRecommendations();
});

function testButtonClick(type) {
    alert('Button clicked! Type: ' + type);
    
    // Now call the actual function
    switch(type) {
        case 'segmentation':
            loadUserSegmentation();
            break;
        case 'journey':
            loadJourneyMapping();
            break;
        case 'fraud':
            loadFraudDetection();
            break;
        case 'satisfaction':
            loadSatisfactionPrediction();
            break;
        case 'recommendations':
            loadAdminRecommendations();
            break;
    }
}

function loadUserSegmentation() {
    console.log('Loading user segmentation...');
    
    // Show loading state
    const button = document.querySelector('button[onclick*="segmentation"]');
    if (button) {
        button.textContent = 'Loading...';
        button.disabled = true;
    }
    
    const url = '/workwave/Controller/index.php?action=ai_user_segmentation';
    console.log('Fetching from:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.text();
    })
    .then(text => {
        console.log('Raw response text:', text);
        
        try {
            const data = JSON.parse(text);
            console.log('Parsed data:', data);
            
            if (data.success) {
                updateUserSegmentationDisplay(data.segmentation);
                
                // Display recommendations
                document.getElementById('segmentRecommendations').innerHTML = data.recommendations.map(rec => 
                    `<div class="ww-recommendation-item">${rec}</div>`
                ).join('');
            } else {
                console.error('Failed to load user segmentation:', data.message);
                alert('Error: ' + data.message);
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            alert('Invalid JSON response: ' + text.substring(0, 200));
        }
    })
    .catch(error => {
        console.error('Error loading user segmentation:', error);
        alert('Error loading data: ' + error.message);
    })
    .finally(() => {
        // Restore button state
        if (button) {
            button.textContent = 'Analyze User Segments';
            button.disabled = false;
        }
    });
}

function updateUserSegmentationDisplay(data) {
    // Update active users
    document.getElementById('activeCount').textContent = data.active.count.toLocaleString();
    document.getElementById('activePercentage').textContent = data.active.percentage + '%';
    document.getElementById('activeDaysSinceLogin').textContent = data.active.daysSinceLogin;
    document.getElementById('activeApplications').textContent = data.active.applications;
    document.getElementById('activeHealthBar').style.width = '85%';
    document.getElementById('activeHealthLabel').textContent = 'Excellent';
    
    // Update at-risk users
    document.getElementById('atRiskCount').textContent = data.at_risk.count.toLocaleString();
    document.getElementById('atRiskPercentage').textContent = data.at_risk.percentage + '%';
    document.getElementById('atRiskDaysSinceLogin').textContent = data.at_risk.daysSinceLogin;
    document.getElementById('atRiskHealthBar').style.width = '60%';
    document.getElementById('atRiskHealthLabel').textContent = 'Needs Attention';
    
    // Update dormant users
    document.getElementById('dormantCount').textContent = data.dormant.count.toLocaleString();
    document.getElementById('dormantPercentage').textContent = data.dormant.percentage + '%';
    document.getElementById('dormantDaysSinceLogin').textContent = data.dormant.daysSinceLogin;
    document.getElementById('dormantReactivationPotential').textContent = data.dormant.reactivationPotential + '%';
    document.getElementById('dormantHealthBar').style.width = '30%';
    document.getElementById('dormantHealthLabel').textContent = 'Poor';
    
    // Update new users
    document.getElementById('newCount').textContent = data.new.count.toLocaleString();
    document.getElementById('newPercentage').textContent = data.new.percentage + '%';
    document.getElementById('newDaysSinceRegistration').textContent = data.new.daysSinceRegistration;
    document.getElementById('newRetentionRate').textContent = data.new.retentionRate + '%';
    document.getElementById('newHealthBar').style.width = '75%';
    document.getElementById('newHealthLabel').textContent = 'Good';
    
    // Update premium users
    document.getElementById('premiumCount').textContent = data.premium.count.toLocaleString();
    document.getElementById('premiumPercentage').textContent = data.premium.percentage + '%';
    document.getElementById('premiumDaysSinceLogin').textContent = data.premium.daysSinceLogin;
    document.getElementById('premiumUpgradeRate').textContent = data.premium.upgradeRate + '%';
    document.getElementById('premiumHealthBar').style.width = '95%';
    document.getElementById('premiumHealthLabel').textContent = 'Excellent';
}

function loadJourneyMapping() {
    fetch('/workwave/Controller/index.php?action=ai_journey_mapping', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateJourneyDisplay(data.journey_data);
            
            document.getElementById('journeyInsights').innerHTML = data.insights.map(insight => 
                `<div class="ww-recommendation-item">${insight}</div>`
            ).join('');
        } else {
            console.error('Failed to load journey mapping:', data.message);
        }
    })
    .catch(error => {
        console.error('Error loading journey mapping:', error);
    });
}

function updateJourneyDisplay(data) {
    console.log('Journey data:', data);
    
    if (data.registration_funnel) {
        document.getElementById('visitorCount').textContent = data.registration_funnel.visitors.toLocaleString();
        document.getElementById('signupStartedCount').textContent = data.registration_funnel.signups_started.toLocaleString();
        document.getElementById('emailVerifiedCount').textContent = data.registration_funnel.email_verified.toLocaleString();
        document.getElementById('profileCompletedCount').textContent = data.registration_funnel.profile_completed.toLocaleString();
        document.getElementById('activeUsersCount').textContent = data.registration_funnel.active_users.toLocaleString();
        document.getElementById('conversionRate').textContent = data.registration_funnel.conversion_rate + '%';
    } else {
        console.error('Journey funnel data not found');
    }
}

function loadFraudDetection() {
    fetch('/workwave/Controller/index.php?action=ai_fraud_detection', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateFraudDetectionDisplay(data.fraud_data);
        } else {
            console.error('Failed to load fraud detection:', data.message);
        }
    })
    .catch(error => {
        console.error('Error loading fraud detection:', error);
    });
}

function updateFraudDetectionDisplay(data) {
    console.log('Fraud detection data:', data);
    
    if (data.overall_risk) {
        // Update risk level
        const riskElement = document.getElementById('overallRiskLevel');
        const riskValue = document.getElementById('riskValue');
        riskValue.textContent = data.overall_risk.toUpperCase();
        
        // Set risk angle for visual indicator
        let riskAngle = 0;
        if (data.overall_risk === 'low') riskAngle = 90;
        else if (data.overall_risk === 'medium') riskAngle = 180;
        else if (data.overall_risk === 'high') riskAngle = 270;
        else if (data.overall_risk === 'critical') riskAngle = 360;
        
        document.documentElement.style.setProperty('--risk-angle', `${riskAngle}deg`);
        
        // Update metrics
        document.getElementById('suspiciousActivities').textContent = data.suspicious_activities || 0;
        document.getElementById('highRiskUsers').textContent = data.high_risk_users || 0;
        document.getElementById('fraudPatterns').textContent = data.fraud_patterns || 0;
        
        // Update alerts
        if (data.alerts && data.alerts.critical) {
            document.getElementById('criticalAlerts').textContent = data.alerts.critical.length;
            document.getElementById('criticalAlertsList').innerHTML = data.alerts.critical.map(alert => 
                `<div class="ww-alert-item">${alert}</div>`
            ).join('');
        }
        
        if (data.alerts && data.alerts.warning) {
            document.getElementById('warningAlertsList').innerHTML = data.alerts.warning.map(alert => 
                `<div class="ww-alert-item">${alert}</div>`
            ).join('');
        }
        
        if (data.alerts && data.alerts.info) {
            document.getElementById('infoAlertsList').innerHTML = data.alerts.info.map(alert => 
                `<div class="ww-alert-item">${alert}</div>`
            ).join('');
        }
        
        // Update immediate actions
        if (data.immediate_actions) {
            document.getElementById('immediateActions').innerHTML = data.immediate_actions.map(action => 
                `<div class="ww-recommendation-item">${action}</div>`
            ).join('');
        }
    } else {
        console.error('Fraud detection data structure not as expected');
    }
}

function loadSatisfactionPrediction() {
    fetch('/workwave/Controller/index.php?action=ai_satisfaction_prediction', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateSatisfactionDisplay(data.satisfaction_data);
        } else {
            console.error('Failed to load satisfaction prediction:', data.message);
        }
    })
    .catch(error => {
        console.error('Error loading satisfaction prediction:', error);
    });
}

function updateSatisfactionDisplay(data) {
    console.log('Satisfaction data:', data);
    
    if (data.satisfaction_scores) {
        // Update overall score
        document.getElementById('satisfactionScore').textContent = data.satisfaction_scores.overall;
        document.getElementById('satisfactionTrend').textContent = '📈 +0.3';
        
        // Set score angle for visual indicator
        const scoreAngle = (data.satisfaction_scores.overall / 10) * 360;
        document.documentElement.style.setProperty('--score-angle', `${scoreAngle}deg`);
        
        // Update components
        document.getElementById('usabilityValue').textContent = data.satisfaction_scores.platform_usability;
        document.getElementById('usabilityBar').style.width = (data.satisfaction_scores.platform_usability * 10) + '%';
        
        document.getElementById('matchingValue').textContent = data.satisfaction_scores.job_matching;
        document.getElementById('matchingBar').style.width = (data.satisfaction_scores.job_matching * 10) + '%';
        
        document.getElementById('supportValue').textContent = data.satisfaction_scores.customer_support;
        document.getElementById('supportBar').style.width = (data.satisfaction_scores.customer_support * 10) + '%';
        
        document.getElementById('featuresValue').textContent = data.satisfaction_scores.feature_set;
        document.getElementById('featuresBar').style.width = (data.satisfaction_scores.feature_set * 10) + '%';
        
        // Update drivers and issues
        if (data.satisfaction_drivers) {
            document.getElementById('satisfactionDrivers').innerHTML = data.satisfaction_drivers.map(driver => 
                `<div class="ww-recommendation-item">${driver}</div>`
            ).join('');
        }
        
        if (data.dissatisfaction_factors) {
            document.getElementById('dissatisfactionFactors').innerHTML = data.dissatisfaction_factors.map(issue => 
                `<div class="ww-recommendation-item">${issue}</div>`
            ).join('');
        }
        
        // Update predictions
        if (data.predictions) {
            document.getElementById('nextMonthPrediction').textContent = data.predictions.next_month;
            document.getElementById('nextQuarterPrediction').textContent = data.predictions.next_quarter;
            document.getElementById('nextYearPrediction').textContent = data.predictions.next_year;
            document.getElementById('predictionConfidence').textContent = data.predictions.confidence + '%';
        }
    } else {
        console.error('Satisfaction scores data not found');
    }
}

function loadAdminRecommendations() {
    fetch('/workwave/Controller/index.php?action=ai_admin_recommendations', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateRecommendationsDisplay(data.recommendations);
        } else {
            console.error('Failed to load admin recommendations:', data.message);
        }
    })
    .catch(error => {
        console.error('Error loading admin recommendations:', error);
    });
}

function updateRecommendationsDisplay(data) {
    console.log('Recommendations data:', data);
    
    // Check if data has the expected structure
    const recommendations = data.recommendations || data;
    
    // Update recommendation categories
    if (recommendations.user_engagement) {
        document.getElementById('engagementRecommendations').innerHTML = recommendations.user_engagement.map(rec => 
            `<div class="ww-recommendation-item">${rec}</div>`
        ).join('');
    }
    
    if (recommendations.retention_strategies) {
        document.getElementById('retentionRecommendations').innerHTML = recommendations.retention_strategies.map(rec => 
            `<div class="ww-recommendation-item">${rec}</div>`
        ).join('');
    }
    
    if (recommendations.growth_opportunities) {
        document.getElementById('growthRecommendations').innerHTML = recommendations.growth_opportunities.map(rec => 
            `<div class="ww-recommendation-item">${rec}</div>`
        ).join('');
    }
    
    if (recommendations.platform_improvements) {
        document.getElementById('platformRecommendations').innerHTML = recommendations.platform_improvements.map(rec => 
            `<div class="ww-recommendation-item">${rec}</div>`
        ).join('');
    }
    
    if (recommendations.automation_opportunities) {
        document.getElementById('automationRecommendations').innerHTML = recommendations.automation_opportunities.map(rec => 
            `<div class="ww-recommendation-item">${rec}</div>`
        ).join('');
    }
    
    // Update priority actions
    if (recommendations.priority_actions && recommendations.priority_actions.critical) {
        document.getElementById('criticalActions').innerHTML = recommendations.priority_actions.critical.map(action => 
            `<div class="ww-recommendation-item">${action}</div>`
        ).join('');
    }
    
    if (recommendations.priority_actions && recommendations.priority_actions.high) {
        document.getElementById('highPriorityActions').innerHTML = recommendations.priority_actions.high.map(action => 
            `<div class="ww-recommendation-item">${action}</div>`
        ).join('');
    }
    
    if (recommendations.priority_actions && recommendations.priority_actions.medium) {
        document.getElementById('mediumPriorityActions').innerHTML = recommendations.priority_actions.medium.map(action => 
            `<div class="ww-recommendation-item">${action}</div>`
        ).join('');
    }
}
</script>

<?php include __DIR__ . '/../layout/dashboard_footer.php'; ?>
