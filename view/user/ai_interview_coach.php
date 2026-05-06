<?php include __DIR__ . '/../layout/pl_dashboard_header.php'; ?>

<div class="ww-interview-section">
  <div class="ww-interview-card">
    <h1>🎤 AI Interview Coach</h1>
    <p class="ww-subtitle">Practice interviews with AI-powered feedback and coaching</p>

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

    <!-- Job Selection -->
    <div class="ww-section">
      <h2>🎯 Select Interview Type</h2>
      <div class="ww-job-selection">
        <div class="ww-job-grid">
          <div class="ww-job-card" onclick="selectJobType('php-developer')">
            <div class="ww-job-icon">💻</div>
            <h3>PHP Developer</h3>
            <p>Senior PHP Developer position</p>
          </div>
          <div class="ww-job-card" onclick="selectJobType('fullstack')">
            <div class="ww-job-icon">🌐</div>
            <h3>Full Stack Developer</h3>
            <p>JavaScript & Node.js focus</p>
          </div>
          <div class="ww-job-card" onclick="selectJobType('devops')">
            <div class="ww-job-icon">⚙️</div>
            <h3>DevOps Engineer</h3>
            <p>Cloud & Infrastructure role</p>
          </div>
          <div class="ww-job-card" onclick="selectJobType('ui-designer')">
            <div class="ww-job-icon">🎨</div>
            <h3>UI/UX Designer</h3>
            <p>Design & User Experience</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Question Prediction -->
    <div class="ww-section" id="questionSection" style="display: none;">
      <h2>🔮 AI Question Prediction</h2>
      <div class="ww-prediction-area">
        <div class="ww-job-description">
          <h3>Job Description Analysis</h3>
          <textarea id="jobDescription" placeholder="Paste job description here for AI analysis..." rows="6"></textarea>
          <button class="ww-btn-primary" onclick="predictQuestions()">Generate Interview Questions</button>
        </div>
        
        <div class="ww-predicted-questions" id="predictedQuestions" style="display: none;">
          <h3>📋 Likely Interview Questions</h3>
          <div class="ww-questions-grid">
            <div class="ww-question-category">
              <h4>💻 Technical Questions</h4>
              <div id="technicalQuestions"></div>
            </div>
            <div class="ww-question-category">
              <h4>🤝 Behavioral Questions</h4>
              <div id="behavioralQuestions"></div>
            </div>
            <div class="ww-question-category">
              <h4>🎯 Problem-Solving</h4>
              <div id="problemSolvingQuestions"></div>
            </div>
            <div class="ww-question-category">
              <h4>🌟 Culture Fit</h4>
              <div id="cultureQuestions"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mock Interview Simulator -->
    <div class="ww-section" id="interviewSection" style="display: none;">
      <h2>🎤 Mock Interview Simulator</h2>
      <div class="ww-interview-simulator">
        <div class="ww-interview-controls">
          <button class="ww-btn-primary" id="startInterview" onclick="startInterview()">Start Interview</button>
          <button class="ww-btn-secondary" id="stopInterview" onclick="stopInterview()" style="display: none;">End Interview</button>
          <div class="ww-timer" id="interviewTimer">00:00</div>
        </div>
        
        <div class="ww-interview-interface" id="interviewInterface" style="display: none;">
          <div class="ww-current-question">
            <h3>Current Question</h3>
            <div class="ww-question-display" id="currentQuestion">Click "Start Interview" to begin</div>
          </div>
          
          <div class="ww-recording-area">
            <div class="ww-visualizer" id="audioVisualizer">
              <div class="ww-wave-bars">
                <div class="ww-bar"></div>
                <div class="ww-bar"></div>
                <div class="ww-bar"></div>
                <div class="ww-bar"></div>
                <div class="ww-bar"></div>
              </div>
            </div>
            <button class="ww-record-btn" id="recordBtn" onclick="toggleRecording()">
              <span id="recordIcon">🎤</span>
              <span id="recordText">Start Recording</span>
            </button>
          </div>
          
          <div class="ww-transcript-area">
            <h4>📝 Your Answer (Transcript)</h4>
            <div id="answerTranscript" contenteditable="true" placeholder="Your answer will appear here as you speak..."></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Real-time Feedback -->
    <div class="ww-section" id="feedbackSection" style="display: none;">
      <h2>📊 Real-time AI Feedback</h2>
      <div class="ww-feedback-dashboard">
        <div class="ww-feedback-metrics">
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="clarityScore">0%</div>
            <div class="ww-metric-label">Clarity</div>
          </div>
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="confidenceScore">0%</div>
            <div class="ww-metric-label">Confidence</div>
          </div>
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="relevanceScore">0%</div>
            <div class="ww-metric-label">Relevance</div>
          </div>
          <div class="ww-metric-card">
            <div class="ww-metric-value" id="completenessScore">0%</div>
            <div class="ww-metric-label">Completeness</div>
          </div>
        </div>
        
        <div class="ww-feedback-details">
          <div class="ww-feedback-card">
            <h3>🎯 Strengths</h3>
            <ul id="strengthsList"></ul>
          </div>
          <div class="ww-feedback-card">
            <h3>⚠️ Areas for Improvement</h3>
            <ul id="improvementsList"></ul>
          </div>
        </div>
        
        <div class="ww-coaching-tips">
          <h3>🏆 Personalized Coaching Tips</h3>
          <div id="coachingTips"></div>
        </div>
      </div>
    </div>

    <!-- Industry-Specific Coaching -->
    <div class="ww-section" id="coachingSection" style="display: none;">
      <h2>🎓 Industry-Specific Coaching</h2>
      <div class="ww-coaching-modules">
        <div class="ww-module-card">
          <h3>💻 Technical Coaching</h3>
          <div class="ww-module-content">
            <div class="ww-skill-focus">
              <h4>Key Technical Skills</h4>
              <div id="technicalSkills"></div>
            </div>
            <div class="ww-practice-areas">
              <h4>Practice Areas</h4>
              <div id="technicalPractice"></div>
            </div>
          </div>
        </div>
        
        <div class="ww-module-card">
          <h3>🤝 Behavioral Coaching</h3>
          <div class="ww-module-content">
            <div class="ww-skill-focus">
              <h4>Soft Skills Development</h4>
              <div id="behavioralSkills"></div>
            </div>
            <div class="ww-practice-areas">
              <h4>STAR Method Practice</h4>
              <div id="starMethodPractice"></div>
            </div>
          </div>
        </div>
        
        <div class="ww-module-card">
          <h3>🏢 Industry Insights</h3>
          <div class="ww-module-content">
            <div class="ww-skill-focus">
              <h4>Industry Trends</h4>
              <div id="industryTrends"></div>
            </div>
            <div class="ww-practice-areas">
              <h4>Company Culture Fit</h4>
              <div id="cultureFit"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.ww-interview-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.ww-interview-card {
    background: #1a1a2e;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    color: #fff;
}

.ww-interview-card h1 {
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

.ww-job-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.ww-job-card {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.ww-job-card:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-5px);
}

.ww-job-card.selected {
    border-color: #4ade80;
    background: rgba(74, 222, 128, 0.2);
}

.ww-job-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.ww-job-card h3 {
    margin-bottom: 10px;
}

.ww-job-card p {
    opacity: 0.8;
    font-size: 0.9rem;
}

.ww-prediction-area {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 30px;
}

.ww-job-description textarea {
    width: 100%;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.1);
    color: white;
    font-size: 1rem;
    resize: vertical;
    margin-bottom: 15px;
}

.ww-questions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.ww-question-category h4 {
    margin-bottom: 15px;
    opacity: 0.9;
}

.ww-question-item {
    background: rgba(255,255,255,0.1);
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    font-size: 0.9rem;
}

.ww-interview-controls {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.ww-timer {
    font-size: 1.5rem;
    font-weight: bold;
    margin-left: auto;
}

.ww-interview-interface {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.ww-current-question {
    grid-column: 1 / -1;
}

.ww-question-display {
    background: rgba(255,255,255,0.1);
    padding: 20px;
    border-radius: 12px;
    font-size: 1.1rem;
    margin-top: 15px;
}

.ww-recording-area {
    text-align: center;
}

.ww-visualizer {
    margin-bottom: 20px;
}

.ww-wave-bars {
    display: flex;
    justify-content: center;
    gap: 5px;
    height: 60px;
    align-items: flex-end;
}

.ww-bar {
    width: 8px;
    background: linear-gradient(to top, #4ade80, #22d3ee);
    border-radius: 4px;
    animation: wave 1s ease-in-out infinite;
}

.ww-bar:nth-child(2) { animation-delay: 0.1s; }
.ww-bar:nth-child(3) { animation-delay: 0.2s; }
.ww-bar:nth-child(4) { animation-delay: 0.3s; }
.ww-bar:nth-child(5) { animation-delay: 0.4s; }

@keyframes wave {
    0%, 100% { height: 20px; }
    50% { height: 40px; }
}

.ww-record-btn {
    background: #ef4444;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 auto;
}

.ww-record-btn.recording {
    background: #dc2626;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

.ww-transcript-area {
    grid-column: 1 / -1;
}

.ww-transcript-area h4 {
    margin-bottom: 10px;
}

#answerTranscript {
    min-height: 120px;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.1);
    color: white;
    font-size: 1rem;
    line-height: 1.5;
}

.ww-feedback-metrics {
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

.ww-feedback-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.ww-feedback-card {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 20px;
}

.ww-feedback-card h3 {
    margin-bottom: 15px;
    opacity: 0.9;
}

.ww-feedback-card ul {
    list-style: none;
    padding: 0;
}

.ww-feedback-card li {
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.ww-coaching-tips {
    background: rgba(74, 222, 128, 0.1);
    border: 1px solid rgba(74, 222, 128, 0.3);
    border-radius: 12px;
    padding: 20px;
}

.ww-coaching-modules {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.ww-module-card {
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 25px;
}

.ww-module-card h3 {
    margin-bottom: 20px;
    opacity: 0.9;
}

.ww-skill-focus, .ww-practice-areas {
    margin-bottom: 20px;
}

.ww-skill-focus h4, .ww-practice-areas h4 {
    margin-bottom: 10px;
    opacity: 0.8;
    font-size: 0.9rem;
}

.ww-skill-item, .ww-practice-item {
    background: rgba(255,255,255,0.05);
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 8px;
    font-size: 0.85rem;
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

.ww-btn-secondary {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .ww-interview-card {
        padding: 20px;
    }
    
    .ww-prediction-area,
    .ww-interview-interface,
    .ww-feedback-details {
        grid-template-columns: 1fr;
    }
    
    .ww-job-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let selectedJobType = null;
let interviewTimer = null;
let interviewSeconds = 0;
let isRecording = false;
let currentQuestionIndex = 0;

const mockQuestions = {
    'php-developer': {
        technical: [
            'Explain the difference between GET and POST methods in PHP.',
            'How do you prevent SQL injection in PHP applications?',
            'Describe your experience with PHP frameworks like Laravel or Symfony.',
            'How do you optimize PHP application performance?'
        ],
        behavioral: [
            'Tell me about a challenging PHP project you worked on.',
            'How do you stay updated with PHP best practices?',
            'Describe a time you had to debug a complex issue.',
            'How do you approach code reviews?'
        ],
        problem: [
            'How would you design a scalable PHP application?',
            'Explain how you would implement a caching strategy.',
            'Describe your approach to database optimization.',
            'How would you handle high traffic situations?'
        ],
        culture: [
            'What kind of team environment do you thrive in?',
            'How do you handle constructive criticism?',
            'Describe your ideal work culture.',
            'How do you contribute to team knowledge sharing?'
        ]
    },
    'fullstack': {
        technical: [
            'Explain the JavaScript event loop.',
            'How do you handle state management in React applications?',
            'Describe your experience with Node.js and Express.',
            'How do you ensure frontend-backend API security?'
        ],
        behavioral: [
            'Tell me about a full-stack project you\'re proud of.',
            'How do you balance frontend and backend priorities?',
            'Describe your experience working in an agile team.',
            'How do you handle technical disagreements?'
        ],
        problem: [
            'How would you design a real-time chat application?',
            'Explain your approach to responsive web design.',
            'Describe your database design process.',
            'How would you implement user authentication?'
        ],
        culture: [
            'What\'s your approach to learning new technologies?',
            'How do you handle tight deadlines?',
            'Describe your ideal project workflow.',
            'How do you contribute to code quality?'
        ]
    }
};

function selectJobType(type) {
    selectedJobType = type;
    
    // Update UI
    document.querySelectorAll('.ww-job-card').forEach(card => {
        card.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
    
    // Show question section
    document.getElementById('questionSection').style.display = 'block';
    document.getElementById('interviewSection').style.display = 'block';
    document.getElementById('feedbackSection').style.display = 'block';
    document.getElementById('coachingSection').style.display = 'block';
    
    // Load default questions
    loadDefaultQuestions(type);
}

function loadDefaultQuestions(jobType) {
    const questions = mockQuestions[jobType] || mockQuestions['php-developer'];
    
    displayQuestions('technicalQuestions', questions.technical);
    displayQuestions('behavioralQuestions', questions.behavioral);
    displayQuestions('problemSolvingQuestions', questions.problem);
    displayQuestions('cultureQuestions', questions.culture);
}

function displayQuestions(elementId, questions) {
    const container = document.getElementById(elementId);
    container.innerHTML = questions.map((question, index) => 
        `<div class="ww-question-item">${index + 1}. ${question}</div>`
    ).join('');
}

function predictQuestions() {
    const jobDescription = document.getElementById('jobDescription').value;
    if (!jobDescription.trim()) return;
    
    // Simulate AI processing
    setTimeout(() => {
        document.getElementById('predictedQuestions').style.display = 'block';
        
        // Extract keywords and generate relevant questions
        const keywords = extractKeywords(jobDescription);
        const generatedQuestions = generateQuestionsFromKeywords(keywords);
        
        // Update question displays
        Object.keys(generatedQuestions).forEach(category => {
            const elementId = category + 'Questions';
            if (document.getElementById(elementId)) {
                displayQuestions(elementId, generatedQuestions[category]);
            }
        });
    }, 1500);
}

function extractKeywords(text) {
    // Simple keyword extraction simulation
    const commonKeywords = ['PHP', 'JavaScript', 'React', 'Node.js', 'SQL', 'MongoDB', 'Docker', 'AWS', 'team', 'project', 'experience'];
    return commonKeywords.filter(keyword => text.toLowerCase().includes(keyword.toLowerCase()));
}

function generateQuestionsFromKeywords(keywords) {
    // Generate questions based on detected keywords
    const questions = {
        technical: [],
        behavioral: [],
        problem: [],
        culture: []
    };
    
    if (keywords.includes('PHP')) {
        questions.technical.push('How do you ensure PHP code security?');
        questions.problem.push('Describe your PHP debugging process.');
    }
    
    if (keywords.includes('React')) {
        questions.technical.push('Explain React component lifecycle.');
        questions.problem.push('How would you optimize React performance?');
    }
    
    if (keywords.includes('team')) {
        questions.behavioral.push('Describe your experience working in teams.');
        questions.culture.push('How do you handle team conflicts?');
    }
    
    // Add default questions if no specific ones generated
    Object.keys(questions).forEach(category => {
        if (questions[category].length === 0) {
            questions[category] = mockQuestions['php-developer'][category].slice(0, 2);
        }
    });
    
    return questions;
}

function startInterview() {
    // Reset interview state
    currentQuestionIndex = 0;
    interviewSeconds = 0;
    
    // Update UI
    document.getElementById('startInterview').style.display = 'none';
    document.getElementById('stopInterview').style.display = 'inline-block';
    document.getElementById('interviewInterface').style.display = 'grid';
    
    // Start timer
    startTimer();
    
    // Load first question
    loadNextQuestion();
}

function stopInterview() {
    // Stop timer
    stopTimer();
    
    // Update UI
    document.getElementById('startInterview').style.display = 'inline-block';
    document.getElementById('stopInterview').style.display = 'none';
    
    // Generate feedback
    generateFeedback();
}

function startTimer() {
    interviewTimer = setInterval(() => {
        interviewSeconds++;
        const minutes = Math.floor(interviewSeconds / 60);
        const seconds = interviewSeconds % 60;
        document.getElementById('interviewTimer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
}

function stopTimer() {
    if (interviewTimer) {
        clearInterval(interviewTimer);
        interviewTimer = null;
    }
}

function loadNextQuestion() {
    const questions = mockQuestions[selectedJobType] || mockQuestions['php-developer'];
    const allQuestions = [...questions.technical, ...questions.behavioral, ...questions.problem, ...questions.culture];
    
    if (currentQuestionIndex < allQuestions.length) {
        document.getElementById('currentQuestion').textContent = allQuestions[currentQuestionIndex];
        currentQuestionIndex++;
    } else {
        stopInterview();
    }
}

function toggleRecording() {
    isRecording = !isRecording;
    const recordBtn = document.getElementById('recordBtn');
    const recordIcon = document.getElementById('recordIcon');
    const recordText = document.getElementById('recordText');
    
    if (isRecording) {
        recordBtn.classList.add('recording');
        recordIcon.textContent = '⏹️';
        recordText.textContent = 'Stop Recording';
        startVoiceSimulation();
    } else {
        recordBtn.classList.remove('recording');
        recordIcon.textContent = '🎤';
        recordText.textContent = 'Start Recording';
        stopVoiceSimulation();
    }
}

let speechRecognition = null;
if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    speechRecognition = new SpeechRecognition();
    speechRecognition.continuous = true;
    speechRecognition.interimResults = true;
    speechRecognition.lang = 'en-US'; 
    
    speechRecognition.onresult = function(event) {
        let finalTranscript = '';
        for (let i = event.resultIndex; i < event.results.length; ++i) {
            if (event.results[i].isFinal) {
                finalTranscript += event.results[i][0].transcript + ' ';
            }
        }
        
        const transcript = document.getElementById('answerTranscript');
        if (finalTranscript) {
            if(transcript.innerText.trim() === '' || transcript.innerText.includes('Your answer will appear here')) {
                transcript.innerText = finalTranscript;
            } else {
                transcript.innerText += ' ' + finalTranscript;
            }
        }
    };
    
    speechRecognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
    };
}

function startVoiceSimulation() {
    const transcript = document.getElementById('answerTranscript');
    if (transcript.innerText.trim() === '' || transcript.innerText.includes('Your answer will appear here')) {
        transcript.innerText = '';
    }
    
    if (speechRecognition) {
        try {
            speechRecognition.start();
        } catch(e) {
            console.error(e);
        }
    } else {
        transcript.innerText = "[Your browser does not support voice recognition. Please type your answer manually.]\n";
    }
}

function stopVoiceSimulation() {
    if (speechRecognition) {
        try {
            speechRecognition.stop();
        } catch(e) {
            console.error(e);
        }
    }
}

function generateFeedback() {
    const transcriptText = document.getElementById('answerTranscript').innerText.trim();
    const wordCount = transcriptText === '' ? 0 : transcriptText.split(/\s+/).length;
    
    let clarity = 50;
    let confidence = 50;
    let relevance = 50;
    let completeness = 50;
    
    let strengths = [];
    let improvements = [];
    
    if (wordCount < 15) {
        clarity = 40; confidence = 35; relevance = 40; completeness = 20;
        improvements.push("Your answer is too short to fully evaluate.");
        improvements.push("Try using the STAR method (Situation, Task, Action, Result) to expand your answer.");
        strengths.push("Direct to the point.");
    } else {
        completeness = Math.min(100, 40 + (wordCount / 2));
        clarity = Math.min(100, 65 + (Math.random() * 15));
        confidence = Math.min(100, 60 + (wordCount > 40 ? 20 : 0) + (Math.random() * 15));
        relevance = Math.min(100, 75 + (Math.random() * 15));
        
        strengths.push("Good length and detailed explanation provided.");
        
        const textLower = transcriptText.toLowerCase();
        if (textLower.includes("because") || textLower.includes("result") || textLower.includes("achieved") || textLower.includes("led to")) {
            strengths.push("Excellent use of reasoning and results-oriented language.");
            confidence += 10;
        } else {
            improvements.push("Focus more on the concrete results of your actions (quantify if possible).");
        }
        
        if (textLower.includes("i ") || textLower.includes("my ")) {
            strengths.push("Strong use of first-person language to take ownership of your actions.");
        } else {
            improvements.push("Use 'I' instead of 'We' to highlight your specific contributions.");
        }
        
        if (wordCount > 150) {
            improvements.push("Your answer was quite long. Try to be more concise to keep the interviewer engaged.");
            clarity -= 10;
        }
    }
    
    const feedback = {
        clarity: Math.floor(Math.min(100, clarity)),
        confidence: Math.floor(Math.min(100, confidence)),
        relevance: Math.floor(Math.min(100, relevance)),
        completeness: Math.floor(Math.min(100, completeness)),
        strengths: strengths.length > 0 ? strengths : ['Good effort'],
        improvements: improvements.length > 0 ? improvements : ['Keep practicing'],
        coaching: [
            'Practice the STAR method for behavioral questions',
            'Prepare specific metrics and achievements',
            'Research the company\'s tech stack thoroughly',
            'Practice explaining technical concepts simply'
        ]
    };
    
    updateFeedbackDisplay(feedback);
}

function updateFeedbackDisplay(feedback) {
    // Update metrics
    document.getElementById('clarityScore').textContent = feedback.clarity + '%';
    document.getElementById('confidenceScore').textContent = feedback.confidence + '%';
    document.getElementById('relevanceScore').textContent = feedback.relevance + '%';
    document.getElementById('completenessScore').textContent = feedback.completeness + '%';
    
    // Update strengths
    document.getElementById('strengthsList').innerHTML = feedback.strengths.map(strength => 
        `<li>${strength}</li>`
    ).join('');
    
    // Update improvements
    document.getElementById('improvementsList').innerHTML = feedback.improvements.map(improvement => 
        `<li>${improvement}</li>`
    ).join('');
    
    // Update coaching tips
    document.getElementById('coachingTips').innerHTML = feedback.coaching.map(tip => 
        `<div class="ww-skill-item">${tip}</div>`
    ).join('');
    
    // Load coaching content
    loadCoachingContent();
}

function loadCoachingContent() {
    // Industry-specific coaching content
    const coachingContent = {
        technicalSkills: [
            'Advanced PHP patterns and best practices',
            'Database optimization techniques',
            'API design and implementation',
            'Security fundamentals'
        ],
        technicalPractice: [
            'Code review exercises',
            'Performance optimization challenges',
            'Security vulnerability assessments',
            'System design scenarios'
        ],
        behavioralSkills: [
            'Communication techniques',
            'Leadership development',
            'Team collaboration strategies',
            'Conflict resolution methods'
        ],
        starMethodPractice: [
            'Situation: Describe the context',
            'Task: Explain your responsibility',
            'Action: Detail your steps taken',
            'Result: Quantify the outcome'
        ],
        industryTrends: [
            'Cloud-native development',
            'Microservices architecture',
            'DevOps practices',
            'AI integration in development'
        ],
        cultureFit: [
            'Company research techniques',
            'Cultural alignment assessment',
            'Team dynamics understanding',
            'Value proposition articulation'
        ]
    };
    
    // Update coaching displays
    Object.keys(coachingContent).forEach(key => {
        const element = document.getElementById(key);
        if (element) {
            element.innerHTML = coachingContent[key].map(item => 
                `<div class="ww-skill-item">${item}</div>`
            ).join('');
        }
    });
}

// Initialize with default content
document.addEventListener('DOMContentLoaded', function() {
    // Set default job description
    document.getElementById('jobDescription').value = `We are looking for a Senior PHP Developer to join our growing team. The ideal candidate will have strong experience with PHP frameworks, database optimization, and modern web development practices. You will work on scalable applications and collaborate with cross-functional teams.`;
});
</script>

<?php include __DIR__ . '/../layout/pl_dashboard_footer.php'; ?>
