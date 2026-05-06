<?php include __DIR__ . '/../layout/pl_dashboard_header.php'; ?>

<div class="ww-ai-section">
  <div class="ww-ai-card">
    <h1>🤖 Smart Job Matching AI</h1>
    <p class="ww-subtitle">Discover your perfect career match with AI-powered analysis</p>

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

    <!-- Resume Upload Section -->
    <div class="ww-section">
      <h2>📄 Resume Analysis</h2>
      <div class="ww-upload-area" id="resumeUploadArea">
        <div class="ww-upload-content">
          <div class="ww-upload-icon">📁</div>
          <h3>Upload Your Resume</h3>
          <p>Drag and drop your resume or click to browse</p>
          <p class="ww-upload-hint">Supported formats: TXT, PDF, DOC, DOCX (Max 5MB)</p>
          <input type="file" id="resumeFile" accept=".pdf,.doc,.docx,.txt" style="display: none;">
          <button class="ww-btn-primary" onclick="document.getElementById('resumeFile').click()">Choose File</button>
        </div>
      </div>
      
      <div class="ww-analysis-results" id="analysisResults" style="display: none;">
        <h3>🔍 AI Analysis Results</h3>
        <div class="ww-metrics-grid">
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="skillCount">0</div>
            <div class="ww-metric-label">Skills Detected</div>
          </div>
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="experienceYears">0</div>
            <div class="ww-metric-label">Years Experience</div>
          </div>
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="confidenceScore">0%</div>
            <div class="ww-metric-label">Confidence Score</div>
          </div>
        </div>
        
        <div class="ww-skills-breakdown">
          <h4>Extracted Skills</h4>
          <div class="ww-skills-categories">
            <div class="ww-skill-category">
              <h5>💻 Technical Skills</h5>
              <div class="ww-skill-tags" id="technicalSkills"></div>
            </div>
            <div class="ww-skill-category">
              <h5>🤝 Soft Skills</h5>
              <div class="ww-skill-tags" id="softSkills"></div>
            </div>
            <div class="ww-skill-category">
              <h5>🛠️ Tools</h5>
              <div class="ww-skill-tags" id="tools"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Job Matching Section -->
    <div class="ww-section">
      <h2>🎯 Job Compatibility Analysis</h2>
      <div class="ww-job-selector">
        <label>Select a job to analyze compatibility:</label>
        <select id="jobSelector" class="ww-select">
          <option value="">Choose a job...</option>
          <option value="1">Senior PHP Developer</option>
          <option value="2">Full Stack JavaScript Developer</option>
          <option value="3">DevOps Engineer</option>
          <option value="4">UI/UX Designer</option>
          <option value="5">Project Manager</option>
        </select>
        <button class="ww-btn-primary" onclick="analyzeJobCompatibility()">Analyze Match</button>
      </div>
      
      <div class="ww-compatibility-results" id="compatibilityResults" style="display: none;">
        <h3>📊 Compatibility Analysis</h3>
        <div class="ww-compatibility-score">
          <div class="ww-score-circle">
            <div class="ww-score-value" id="overallScore">0%</div>
            <div class="ww-score-label">Overall Match</div>
          </div>
          <div class="ww-score-breakdown">
            <div class="ww-score-item">
              <span class="ww-score-name">Skills</span>
              <div class="ww-score-bar">
                <div class="ww-score-fill" id="skillMatchBar" style="width: 0%"></div>
              </div>
              <span class="ww-score-percent" id="skillMatchPercent">0%</span>
            </div>
            <div class="ww-score-item">
              <span class="ww-score-name">Experience</span>
              <div class="ww-score-bar">
                <div class="ww-score-fill" id="experienceMatchBar" style="width: 0%"></div>
              </div>
              <span class="ww-score-percent" id="experienceMatchPercent">0%</span>
            </div>
            <div class="ww-score-item">
              <span class="ww-score-name">Education</span>
              <div class="ww-score-bar">
                <div class="ww-score-fill" id="educationMatchBar" style="width: 0%"></div>
              </div>
              <span class="ww-score-percent" id="educationMatchPercent">0%</span>
            </div>
          </div>
        </div>
        
        <div class="ww-recommendation-box">
          <h4>💡 Recommendation</h4>
          <p id="jobRecommendation"></p>
        </div>
        
        <div class="ww-missing-skills" id="missingSkillsSection" style="display: none;">
          <h4>📚 Skills to Develop</h4>
          <div class="ww-skill-tags" id="missingSkills"></div>
        </div>
      </div>
    </div>

    <!-- Career Recommendations Section -->
    <div class="ww-section">
      <h2>🚀 Career Path Recommendations</h2>
      <button class="ww-btn-primary" onclick="getCareerRecommendations()">Get AI Career Advice</button>
      
      <div class="ww-career-results" id="careerResults" style="display: none;">
        <div class="ww-career-grid">
          <div class="ww-career-card">
            <h3>📈 Next Level Positions</h3>
            <div id="nextLevelPositions"></div>
          </div>
          <div class="ww-career-card">
            <h3>🎯 Skill Development</h3>
            <div id="skillDevelopment"></div>
          </div>
          <div class="ww-career-card">
            <h3>💰 Salary Projections</h3>
            <div id="salaryProjections"></div>
          </div>
          <div class="ww-career-card">
            <h3>📊 Industry Trends</h3>
            <div id="industryTrends"></div>
          </div>
        </div>
        
        <div class="ww-learning-resources">
          <h3>📚 Recommended Learning Resources</h3>
          <div id="learningResources"></div>
        </div>
      </div>
    </div>

    <!-- Salary Negotiation Section -->
    <div class="ww-section">
      <h2>💼 Salary Negotiation Assistant</h2>
      <div class="ww-salary-form">
        <div class="ww-form-row">
          <select id="salaryJobSelector" class="ww-select">
            <option value="">Select job for salary analysis...</option>
            <option value="1">Senior PHP Developer</option>
            <option value="2">Full Stack JavaScript Developer</option>
            <option value="3">DevOps Engineer</option>
          </select>
          <button class="ww-btn-primary" onclick="getSalaryAnalysis()">Analyze Salary</button>
        </div>
      </div>
      
      <div class="ww-salary-results" id="salaryResults" style="display: none;">
        <h3>💰 Market Salary Analysis</h3>
        <div class="ww-salary-overview">
          <div class="ww-salary-card">
            <h4>Market Range</h4>
            <div class="ww-salary-range" id="marketRange"></div>
          </div>
          <div class="ww-salary-card">
            <h4>Recommended Range</h4>
            <div class="ww-salary-range" id="recommendedRange"></div>
          </div>
          <div class="ww-salary-card">
            <h4>Negotiation Confidence</h4>
            <div class="ww-confidence-level" id="negotiationConfidence"></div>
          </div>
        </div>
        
        <div class="ww-negotiation-points">
          <h4>🎯 Negotiation Points</h4>
          <ul id="negotiationPoints"></ul>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.ww-ai-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.ww-ai-card {
    background: #1a1a2e;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    color: #fff;
}

.ww-ai-card h1 {
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

.ww-upload-area {
    border: 2px dashed rgba(255,255,255,0.3);
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.ww-upload-area:hover {
    border-color: rgba(255,255,255,0.6);
    background: rgba(255,255,255,0.05);
}

.ww-upload-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.ww-upload-content h3 {
    margin-bottom: 10px;
}

.ww-upload-hint {
    font-size: 0.9rem;
    opacity: 0.7;
    margin-top: 10px;
}

.ww-analysis-results {
    margin-top: 30px;
}

.ww-metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ww-metric-card {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}

.ww-metric-value {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.ww-metric-label {
    opacity: 0.8;
    font-size: 0.9rem;
}

.ww-skills-breakdown {
    margin-top: 20px;
}

.ww-skills-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.ww-skill-category h5 {
    margin-bottom: 10px;
    opacity: 0.9;
}

.ww-skill-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.ww-skill-tag {
    background: rgba(255,255,255,0.2);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.ww-job-selector {
    display: flex;
    gap: 15px;
    align-items: center;
    margin-bottom: 30px;
}

.ww-select {
    flex: 1;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.1);
    color: white;
    font-size: 1rem;
}

.ww-compatibility-score {
    display: flex;
    gap: 30px;
    align-items: center;
    margin-bottom: 30px;
}

.ww-score-circle {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: conic-gradient(#4ade80 0deg, #4ade80 var(--score), rgba(255,255,255,0.2) var(--score));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
}

.ww-score-circle::before {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
}

.ww-score-value {
    font-size: 2rem;
    font-weight: bold;
    z-index: 1;
}

.ww-score-label {
    font-size: 0.9rem;
    opacity: 0.8;
    z-index: 1;
}

.ww-score-breakdown {
    flex: 1;
}

.ww-score-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.ww-score-name {
    width: 100px;
}

.ww-score-bar {
    flex: 1;
    height: 8px;
    background: rgba(255,255,255,0.2);
    border-radius: 4px;
    overflow: hidden;
}

.ww-score-fill {
    height: 100%;
    background: linear-gradient(90deg, #4ade80, #22d3ee);
    transition: width 1s ease;
}

.ww-score-percent {
    width: 50px;
    text-align: right;
}

.ww-recommendation-box {
    background: rgba(74, 222, 128, 0.1);
    border: 1px solid rgba(74, 222, 128, 0.3);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.ww-career-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ww-career-card {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 20px;
}

.ww-career-card h3 {
    margin-bottom: 15px;
    opacity: 0.9;
}

.ww-salary-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.ww-salary-card {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}

.ww-salary-range {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 10px;
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
    .ww-ai-card {
        padding: 20px;
    }
    
    .ww-compatibility-score {
        flex-direction: column;
    }
    
    .ww-score-circle {
        width: 120px;
        height: 120px;
    }
    
    .ww-score-circle::before {
        width: 100px;
        height: 100px;
    }
}
</style>

<script>
let currentExtractedSkills = [];

document.addEventListener('DOMContentLoaded', function() {
    // File upload handling
    const resumeFile = document.getElementById('resumeFile');
    const uploadArea = document.getElementById('resumeUploadArea');
    
    uploadArea.addEventListener('click', () => resumeFile.click());
    
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = 'rgba(255,255,255,0.6)';
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.borderColor = 'rgba(255,255,255,0.3)';
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = 'rgba(255,255,255,0.3)';
        handleFileSelect(e.dataTransfer.files[0]);
    });
    
    resumeFile.addEventListener('change', (e) => {
        handleFileSelect(e.target.files[0]);
    });
});

function handleFileSelect(file) {
    if (file && file.size <= 5242880) { // 5MB limit
        if (file.type === 'text/plain' || file.name.endsWith('.txt')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                setTimeout(() => {
                    processResumeText(e.target.result);
                }, 800);
            };
            reader.readAsText(file);
        } else {
            // Simulated fallback for PDF/DOCX
            setTimeout(() => {
                processResume(file);
            }, 1500);
        }
    } else {
        alert("File is too large or invalid.");
    }
}

function processResumeText(text) {
    const textLower = text.toLowerCase();
    
    const dictProgramming = ['php', 'javascript', 'python', 'java', 'c++', 'ruby', 'go', 'mysql', 'sql', 'mongodb', 'react', 'angular', 'vue', 'node.js', 'typescript', 'html', 'css', 'laravel', 'symfony', 'bash'];
    const dictSoft = ['communication', 'teamwork', 'leadership', 'problem solving', 'agile', 'scrum', 'management', 'critical thinking', 'adaptability', 'organization'];
    const dictTools = ['git', 'docker', 'jira', 'vs code', 'aws', 'azure', 'linux', 'kubernetes', 'jenkins', 'figma', 'github', 'gitlab'];
    
    const foundProgramming = dictProgramming.filter(skill => textLower.includes(skill));
    const foundSoft = dictSoft.filter(skill => textLower.includes(skill));
    const foundTools = dictTools.filter(skill => textLower.includes(skill));
    
    let years = 1;
    if (textLower.includes('senior') || textLower.includes('lead')) years += 4;
    if (textLower.includes('mid') || textLower.match(/\b(3|4|5) (years|ans|années)\b/)) years += 2;
    if (textLower.length > 1000) years += 1;
    
    const analysis = {
        skills: {
            programming: foundProgramming.length > 0 ? foundProgramming.map(s => s.toUpperCase()) : ['PHP', 'HTML'],
            soft_skills: foundSoft.length > 0 ? foundSoft.map(s => s.charAt(0).toUpperCase() + s.slice(1)) : ['Communication'],
            tools: foundTools.length > 0 ? foundTools.map(s => s.toUpperCase()) : ['GIT']
        },
        experience: { years: Math.min(10, years), level: years > 4 ? 'senior' : (years > 2 ? 'mid' : 'junior') },
        education: { level: textLower.includes('bachelor') || textLower.includes('master') || textLower.includes('diploma') || textLower.includes('licence') || textLower.includes('ingénieur') ? 'bachelor' : 'unknown', detected: true },
        confidence: 94
    };
    
    currentExtractedSkills = [...foundProgramming, ...foundTools, ...foundSoft];
    displayAnalysisResults(analysis);
}

function processResume(file) {
    const mockAnalysis = {
        skills: {
            programming: ['PHP', 'JavaScript', 'MySQL', 'React'],
            soft_skills: ['Communication', 'Teamwork', 'Problem Solving'],
            tools: ['Git', 'Docker', 'Jira', 'VS Code']
        },
        experience: { years: 3, level: 'mid' },
        education: { level: 'bachelor', detected: true },
        confidence: 85
    };
    
    currentExtractedSkills = ['php', 'javascript', 'mysql', 'react', 'git', 'docker', 'jira', 'communication'];
    displayAnalysisResults(mockAnalysis);
}

function displayAnalysisResults(analysis) {
    const resultsDiv = document.getElementById('analysisResults');
    resultsDiv.style.display = 'block';
    
    document.getElementById('skillCount').textContent = 
        Object.values(analysis.skills).flat().length;
    document.getElementById('experienceYears').textContent = analysis.experience.years;
    document.getElementById('confidenceScore').textContent = analysis.confidence + '%';
    
    displaySkills('technicalSkills', analysis.skills.programming);
    displaySkills('softSkills', analysis.skills.soft_skills);
    displaySkills('tools', analysis.skills.tools);
}

function displaySkills(elementId, skills) {
    const container = document.getElementById(elementId);
    container.innerHTML = skills.map(skill => 
        `<span class="ww-skill-tag">${skill}</span>`
    ).join('');
}

function analyzeJobCompatibility() {
    const jobSelector = document.getElementById('jobSelector');
    const jobId = jobSelector.value;
    
    if (!jobId) return;
    if (currentExtractedSkills.length === 0) {
        alert("Please upload and analyze a resume first.");
        return;
    }
    
    const jobRequirements = {
        '1': ['php', 'mysql', 'laravel', 'git', 'javascript'],
        '2': ['javascript', 'react', 'node.js', 'mongodb', 'html', 'css'],
        '3': ['docker', 'aws', 'linux', 'kubernetes', 'python', 'git'],
        '4': ['figma', 'html', 'css', 'javascript', 'communication'],
        '5': ['agile', 'scrum', 'jira', 'leadership', 'communication']
    };
    
    const required = jobRequirements[jobId] || [];
    const missing = required.filter(skill => !currentExtractedSkills.includes(skill));
    const matched = required.filter(skill => currentExtractedSkills.includes(skill));
    
    const skillScore = required.length > 0 ? Math.round((matched.length / required.length) * 100) : 0;
    
    setTimeout(() => {
        const mockCompatibility = {
            overall_score: Math.round((skillScore * 0.7) + 25),
            skill_match: skillScore,
            experience_match: currentExtractedSkills.length > 5 ? 85 : 50,
            education_match: 90,
            recommendation: skillScore > 60 ? 'Strong Match - You are highly recommended to apply!' : 'Low Match - Consider developing the missing skills.',
            missing_skills: missing.map(s => s.toUpperCase())
        };
        
        displayCompatibilityResults(mockCompatibility);
    }, 800);
}

function displayCompatibilityResults(data) {
    const resultsDiv = document.getElementById('compatibilityResults');
    resultsDiv.style.display = 'block';
    
    // Update score circle
    document.getElementById('overallScore').textContent = data.overall_score + '%';
    document.documentElement.style.setProperty('--score', `${data.overall_score * 3.6}deg`);
    
    // Update score bars
    updateScoreBar('skillMatch', data.skill_match);
    updateScoreBar('experienceMatch', data.experience_match);
    updateScoreBar('educationMatch', data.education_match);
    
    // Update recommendation
    document.getElementById('jobRecommendation').textContent = data.recommendation;
    
    // Update missing skills
    if (data.missing_skills.length > 0) {
        document.getElementById('missingSkillsSection').style.display = 'block';
        displaySkills('missingSkills', data.missing_skills);
    }
}

function updateScoreBar(prefix, value) {
    document.getElementById(prefix + 'Bar').style.width = value + '%';
    document.getElementById(prefix + 'Percent').textContent = value + '%';
}

function getCareerRecommendations() {
    // Simulate API call
    setTimeout(() => {
        const mockCareer = {
            next_level_positions: {
                'Senior Developer': '85% match',
                'Team Lead': '70% match',
                'Solution Architect': '65% match'
            },
            skill_development: {
                'Advanced JavaScript': 'Recommended for senior roles',
                'Cloud Architecture': 'High demand skill',
                'System Design': 'Essential for leadership'
            },
            salary_projections: {
                'Current': '$60,000 - $75,000',
                'Next Year': '$65,000 - $85,000',
                '5 Years': '$85,000 - $120,000'
            },
            industry_trends: {
                'Remote Work': 'Growing 25% annually',
                'AI/ML Integration': 'Critical future skill',
                'Microservices': 'Industry standard'
            },
            learning_resources: {
                'Coursera': 'Advanced System Design',
                'Udemy': 'Cloud Architecture Masterclass',
                'Pluralsight': 'JavaScript Advanced Patterns'
            }
        };
        
        displayCareerResults(mockCareer);
    }, 1200);
}

function displayCareerResults(data) {
    document.getElementById('careerResults').style.display = 'block';
    
    displayList('nextLevelPositions', data.next_level_positions);
    displayList('skillDevelopment', data.skill_development);
    displayList('salaryProjections', data.salary_projections);
    displayList('industryTrends', data.industry_trends);
    displayList('learningResources', data.learning_resources);
}

function displayList(elementId, items) {
    const container = document.getElementById(elementId);
    container.innerHTML = Object.entries(items).map(([key, value]) => 
        `<div style="margin-bottom: 8px;"><strong>${key}:</strong> ${value}</div>`
    ).join('');
}

function getSalaryAnalysis() {
    const jobId = document.getElementById('salaryJobSelector').value;
    if (!jobId) return;
    
    // Simulate API call
    setTimeout(() => {
        const mockSalary = {
            market_range: '$65,000 - $85,000',
            recommended_range: '$70,000 - $90,000',
            confidence: 'High - Strong negotiating position',
            negotiation_points: [
                'Market rate is 15% higher than listed',
                'Your experience justifies premium compensation',
                'In-demand technical skills',
                'Company benefits above industry average'
            ]
        };
        
        displaySalaryResults(mockSalary);
    }, 1000);
}

function displaySalaryResults(data) {
    document.getElementById('salaryResults').style.display = 'block';
    
    document.getElementById('marketRange').textContent = data.market_range;
    document.getElementById('recommendedRange').textContent = data.recommended_range;
    document.getElementById('negotiationConfidence').textContent = data.confidence;
    
    const pointsList = document.getElementById('negotiationPoints');
    pointsList.innerHTML = data.negotiation_points.map(point => 
        `<li>${point}</li>`
    ).join('');
}
</script>

<?php include __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>
