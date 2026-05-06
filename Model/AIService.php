<?php
require_once __DIR__ . '/config.php';

class AIService {
    private static $model = 'gemini-1.5-flash';

    /**
     * Classifies a mission based on its title and description.
     * Returns a JSON with suggested category and level.
     */
    public static function classifyMission($title, $description) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/" . self::$model . ":generateContent?key=" . GEMINI_API_KEY;

        $prompt = "You are a professional HR assistant. Based on the following mission title and description, suggest the most appropriate category, seniority level, and extract a list of at least 5 key skills required.
        
        Mission Title: \"$title\"
        Mission Description: \"$description\"

        Possible Categories:
        - developpement (Web Development)
        - mobile (Mobile & App)
        - design (Design & Creative)
        - marketing (Marketing & Comm)
        - data (Data Science)

        Possible Levels:
        - debutant (Junior)
        - intermediaire (Intermediate)
        - avance (Senior)
        - expert (Expert)

        Return ONLY a JSON object with three keys: 'categorie', 'niveau', and 'competences' (comma separated string). Use the keys exactly as listed above.
        Example: {\"categorie\": \"developpement\", \"niveau\": \"intermediaire\", \"competences\": \"PHP, React, MySQL, Git, Docker\"}";

        $data = [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ];

        $attempts = 0;
        $maxAttempts = 3;
        $response = null;
        $httpCode = 0;

        while ($attempts < $maxAttempts) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                error_log("AIService Curl Error (Attempt " . ($attempts+1) . "): " . $error);
            } elseif ($httpCode === 200) {
                break; // Success
            } elseif ($httpCode === 429 || $httpCode === 503) {
                error_log("AIService API Error $httpCode (Attempt " . ($attempts+1) . "): " . $response);
                $attempts++;
                if ($attempts < $maxAttempts) {
                    sleep(1); // Wait before retry
                    continue;
                }
            } else {
                error_log("AIService Unexpected Error $httpCode: " . $response);
                break;
            }
            $attempts++;
        }

        if ($httpCode === 200 && $response) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $jsonText = $result['candidates'][0]['content']['parts'][0]['text'];
                $jsonText = preg_replace('/```json|```/', '', $jsonText);
                $decoded = json_decode(trim($jsonText), true);
                if ($decoded) return $decoded;
            }
        }

        error_log("AIService: Falling back to default classification");
        return self::getFallbackClassification($title, $description);
    }

    private static function getFallbackClassification($title, $description) {
        $titleLower = strtolower($title . ' ' . $description);
        
        // 1. Detect Category
        $categorie = 'developpement';
        $competences = 'PHP, JavaScript, SQL, HTML5, CSS3'; // Default Dev skills
        
        if (strpos($titleLower, 'mobile') !== false || strpos($titleLower, 'ios') !== false || strpos($titleLower, 'android') !== false) {
            $categorie = 'mobile';
            $competences = 'React Native, Flutter, Swift, Kotlin, Firebase';
        } elseif (strpos($titleLower, 'design') !== false || strpos($titleLower, 'ux') !== false || strpos($titleLower, 'ui') !== false) {
            $categorie = 'design';
            $competences = 'Figma, Adobe XD, Photoshop, UI Design, Prototyping';
        } elseif (strpos($titleLower, 'marketing') !== false || strpos($titleLower, 'pub') !== false) {
            $categorie = 'marketing';
            $competences = 'SEO, Google Ads, Social Media, Copywriting, Analytics';
        } elseif (strpos($titleLower, 'data') !== false || strpos($titleLower, 'python') !== false) {
            $categorie = 'data';
            $competences = 'Python, SQL, Machine Learning, Data Viz, Pandas';
        }

        // 2. Detect Level
        $niveau = 'intermediaire'; // Default
        if (strpos($titleLower, 'junior') !== false || strpos($titleLower, 'débutant') !== false || strpos($titleLower, 'stage') !== false) {
            $niveau = 'debutant';
        } elseif (strpos($titleLower, 'senior') !== false || strpos($titleLower, 'avancé') !== false || strpos($titleLower, 'confirmé') !== false) {
            $niveau = 'avance';
        } elseif (strpos($titleLower, 'expert') !== false || strpos($titleLower, 'architecte') !== false || strpos($titleLower, 'lead') !== false) {
            $niveau = 'expert';
        }

        return [
            'categorie' => $categorie,
            'niveau' => $niveau,
            'competences' => $competences,
            'is_fallback' => true
        ];
    }
}
