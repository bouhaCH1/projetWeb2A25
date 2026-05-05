<?php

require_once __DIR__ . '/../Model/Database.php';

class AIController {
    
    private PDO $pdo;
    
    public function __construct() {
        $this->pdo = getConnection();
    }
    
    /**
     * Resume Parsing with AI Skill Extraction
     */
    public function parseResume(string $resumeText): array {
        try {
            // Extract skills using pattern matching and AI analysis
            $skills = $this->extractSkills($resumeText);
            $experience = $this->extractExperience($resumeText);
            $education = $this->extractEducation($resumeText);
            
            return [
                'success' => true,
                'skills' => $skills,
                'experience' => $experience,
                'education' => $education,
                'confidence_score' => $this->calculateConfidence($skills, $experience, $education)
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Resume parsing failed: ' . $e->getMessage()];
        }
    }
    
    /**
     * Job Compatibility Scoring (0-100% match)
     */
    public function calculateJobMatch(int $userId, int $jobId): array {
        try {
            // Get user profile
            $userProfile = $this->getUserProfile($userId);
            
            // Get job requirements
            $jobRequirements = $this->getJobRequirements($jobId);
            
            // Calculate skill match percentage
            $skillMatch = $this->calculateSkillMatch($userProfile['skills'], $jobRequirements['required_skills']);
            
            // Calculate experience match
            $experienceMatch = $this->calculateExperienceMatch($userProfile['experience'], $jobRequirements['experience_level']);
            
            // Calculate education match
            $educationMatch = $this->calculateEducationMatch($userProfile['education'], $jobRequirements['education']);
            
            // Calculate overall compatibility score
            $overallScore = ($skillMatch * 0.5) + ($experienceMatch * 0.3) + ($educationMatch * 0.2);
            
            return [
                'success' => true,
                'overall_score' => round($overallScore, 1),
                'skill_match' => round($skillMatch, 1),
                'experience_match' => round($experienceMatch, 1),
                'education_match' => round($educationMatch, 1),
                'recommendation' => $this->getRecommendation($overallScore),
                'missing_skills' => $this->getMissingSkills($userProfile['skills'], $jobRequirements['required_skills'])
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Job matching failed: ' . $e->getMessage()];
        }
    }
    
    /**
     * Career Path Recommendations
     */
    public function getCareerRecommendations(int $userId): array {
        try {
            $userProfile = $this->getUserProfile($userId);
            
            $recommendations = [
                'next_level_positions' => $this->getNextLevelPositions($userProfile),
                'skill_development' => $this->getSkillDevelopmentPlan($userProfile),
                'salary_projections' => $this->getSalaryProjections($userProfile),
                'industry_trends' => $this->getIndustryTrends($userProfile),
                'learning_resources' => $this->getLearningResources($userProfile)
            ];
            
            return ['success' => true, 'recommendations' => $recommendations];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Career recommendations failed: ' . $e->getMessage()];
        }
    }
    
    /**
     * Salary Negotiation Assistant
     */
    public function getSalaryAnalysis(int $userId, int $jobId): array {
        try {
            $userProfile = $this->getUserProfile($userId);
            $jobInfo = $this->getJobInfo($jobId);
            
            // Get market data for similar positions
            $marketData = $this->getMarketSalaryData($jobInfo['title'], $jobInfo['location'], $userProfile['experience']);
            
            // Calculate recommended salary range
            $recommendedRange = $this->calculateSalaryRange($marketData, $userProfile);
            
            // Generate negotiation points
            $negotiationPoints = $this->generateNegotiationPoints($userProfile, $jobInfo, $marketData);
            
            return [
                'success' => true,
                'market_range' => $marketData,
                'recommended_range' => $recommendedRange,
                'negotiation_points' => $negotiationPoints,
                'confidence_level' => $this->calculateNegotiationConfidence($userProfile, $marketData)
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Salary analysis failed: ' . $e->getMessage()];
        }
    }
    
    // Private helper methods
    
    private function extractSkills(string $text): array {
        // Common tech skills patterns
        $skillPatterns = [
            'programming' => '/\b(PHP|JavaScript|Python|Java|C\+\+|React|Vue|Angular|Node\.js|SQL|MongoDB|MySQL|PostgreSQL|HTML|CSS|Git|Docker|AWS|Azure|GCP)\b/i',
            'soft_skills' => '/\b(communication|leadership|teamwork|problem solving|project management|analytical|creative|detail-oriented|time management)\b/i',
            'tools' => '/\b(Office|Excel|PowerPoint|Word|Photoshop|Illustrator|Figma|Sketch|Jira|Trello|Slack|Teams|Zoom)\b/i'
        ];
        
        $extractedSkills = [];
        foreach ($skillPatterns as $category => $pattern) {
            if (preg_match_all($pattern, $text, $matches)) {
                $extractedSkills[$category] = array_unique($matches[0]);
            }
        }
        
        return $extractedSkills;
    }
    
    private function extractExperience(string $text): array {
        // Extract years of experience
        if (preg_match('/(\d+)\+?\s*(?:years?|ans?)\s*(?:of\s*)?(?:experience|expérience)/i', $text, $matches)) {
            return ['years' => (int)$matches[1], 'level' => $this->getExperienceLevel((int)$matches[1])];
        }
        
        return ['years' => 0, 'level' => 'entry'];
    }
    
    private function extractEducation(string $text): array {
        $educationLevels = [
            'phd' => ['phd', 'doctorate', 'doctorat'],
            'master' => ['master', 'm.sc', 'm.s.', 'maîtrise'],
            'bachelor' => ['bachelor', 'b.sc', 'b.s.', 'licence', 'engineering'],
            'associate' => ['associate', 'diploma', 'dut', 'dut']
        ];
        
        foreach ($educationLevels as $level => $keywords) {
            foreach ($keywords as $keyword) {
                if (preg_match("/\b$keyword\b/i", $text)) {
                    return ['level' => $level, 'detected' => true];
                }
            }
        }
        
        return ['level' => 'unknown', 'detected' => false];
    }
    
    private function calculateConfidence(array $skills, array $experience, array $education): float {
        $confidence = 0;
        
        if (!empty($skills['programming'])) $confidence += 30;
        if (!empty($skills['soft_skills'])) $confidence += 20;
        if ($experience['years'] > 0) $confidence += 30;
        if ($education['detected']) $confidence += 20;
        
        return min($confidence, 100);
    }
    
    private function getExperienceLevel(int $years): string {
        if ($years >= 10) return 'senior';
        if ($years >= 5) return 'mid-senior';
        if ($years >= 2) return 'mid';
        if ($years >= 1) return 'junior';
        return 'entry';
    }
    
    private function getUserProfile(int $userId): array {
        $stmt = $this->pdo->prepare('
            SELECT u.*, GROUP_CONCAT(DISTINCT s.skill_name) as skills
            FROM users u
            LEFT JOIN user_skills s ON u.id = s.user_id
            WHERE u.id = :id
            GROUP BY u.id
        ');
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    
    private function getJobRequirements(int $jobId): array {
        $stmt = $this->pdo->prepare('
            SELECT m.*, GROUP_CONCAT(DISTINCT r.skill_name) as required_skills
            FROM mission m
            LEFT JOIN mission_requirements r ON m.id = r.mission_id
            WHERE m.id = :id
            GROUP BY m.id
        ');
        $stmt->execute([':id' => $jobId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    
    private function calculateSkillMatch(string $userSkills, string $jobSkills): float {
        $userSkillArray = explode(',', $userSkills);
        $jobSkillArray = explode(',', $jobSkills);
        
        if (empty($jobSkillArray[0])) return 100;
        
        $matchingSkills = array_intersect($userSkillArray, $jobSkillArray);
        return (count($matchingSkills) / count($jobSkillArray)) * 100;
    }
    
    private function calculateExperienceMatch(array $userExp, string $requiredLevel): float {
        $levels = ['entry' => 0, 'junior' => 1, 'mid' => 2, 'mid-senior' => 3, 'senior' => 4];
        
        $userLevel = $levels[$userExp['level']] ?? 0;
        $requiredLevelNum = $levels[$requiredLevel] ?? 0;
        
        if ($userLevel >= $requiredLevelNum) return 100;
        return ($userLevel / $requiredLevelNum) * 100;
    }
    
    private function calculateEducationMatch(array $userEdu, string $required): float {
        $levels = ['unknown' => 0, 'associate' => 25, 'bachelor' => 50, 'master' => 75, 'phd' => 100];
        
        $userLevel = $levels[$userEdu['level']] ?? 0;
        $requiredLevel = $levels[$required] ?? 0;
        
        if ($userLevel >= $requiredLevel) return 100;
        return ($userLevel / $requiredLevel) * 100;
    }
    
    private function getRecommendation(float $score): string {
        if ($score >= 85) return 'Excellent match - Strongly recommended to apply';
        if ($score >= 70) return 'Good match - Recommended to apply';
        if ($score >= 50) return 'Moderate match - Consider applying with additional qualifications';
        return 'Low match - May need additional skills or experience';
    }
    
    private function getMissingSkills(string $userSkills, string $jobSkills): array {
        $userSkillArray = array_map('trim', explode(',', $userSkills));
        $jobSkillArray = array_map('trim', explode(',', $jobSkills));
        
        return array_diff($jobSkillArray, $userSkillArray);
    }
    
    // Placeholder methods for career recommendations
    private function getNextLevelPositions(array $profile): array {
        return [
            'Senior Developer' => '85% match',
            'Team Lead' => '70% match',
            'Project Manager' => '60% match'
        ];
    }
    
    private function getSkillDevelopmentPlan(array $profile): array {
        return [
            'Advanced JavaScript' => 'Recommended for senior roles',
            'Cloud Architecture' => 'High demand skill',
            'Agile Methodologies' => 'Industry standard'
        ];
    }
    
    private function getSalaryProjections(array $profile): array {
        return [
            'current_range' => '$45,000 - $65,000',
            'next_year' => '$50,000 - $72,000',
            '5_year' => '$65,000 - $95,000'
        ];
    }
    
    private function getIndustryTrends(array $profile): array {
        return [
            'Remote work' => 'Growing 15% annually',
            'AI/ML skills' => 'High demand (+25%)',
            'Cloud computing' => 'Essential skill'
        ];
    }
    
    private function getLearningResources(array $profile): array {
        return [
            'Coursera' => 'Advanced JavaScript Course',
            'Udemy' => 'Cloud Architecture',
            'LinkedIn Learning' => 'Project Management'
        ];
    }
    
    // Placeholder methods for salary analysis
    private function getJobInfo(int $jobId): array {
        $stmt = $this->pdo->prepare('SELECT * FROM mission WHERE id = :id');
        $stmt->execute([':id' => $jobId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    
    private function getMarketSalaryData(string $title, string $location, int $experience): array {
        // Simulated market data - in production, integrate with real salary APIs
        return [
            'min' => 45000,
            'max' => 75000,
            'median' => 60000,
            'percentile_25' => 52000,
            'percentile_75' => 68000,
            'source' => 'Market Analysis'
        ];
    }
    
    private function calculateSalaryRange(array $marketData, array $profile): array {
        $base = $marketData['median'];
        
        // Adjust based on experience
        $experienceMultiplier = 1 + ($profile['experience']['years'] * 0.05);
        
        // Adjust based on skills
        $skillMultiplier = 1.1; // Placeholder
        
        $adjusted = $base * $experienceMultiplier * $skillMultiplier;
        
        return [
            'min' => round($adjusted * 0.9),
            'max' => round($adjusted * 1.2),
            'target' => round($adjusted)
        ];
    }
    
    private function generateNegotiationPoints(array $profile, array $jobInfo, array $marketData): array {
        return [
            'Market rate is higher than listed',
            'Your experience justifies premium',
            'Skills in high demand',
            'Company benefits comparison'
        ];
    }
    
    private function calculateNegotiationConfidence(array $profile, array $marketData): string {
        return 'High - Strong negotiating position';
    }
}
