<?php
require_once __DIR__ . '/config.php';

class AIService {
    private static $model = 'gemini-pro';

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

    /**
     * Responds to a user chat message as a support assistant.
     */
    public static function chat($message) {
        // Simple rule-based responses for demo
        $message = strtolower(trim($message));
        
        // Greetings
        if (preg_match('/(salut|bonjour|hello|hi|hey)/', $message)) {
            return "Bonjour ! Je suis votre assistant IA pour Work Wave. Comment puis-je vous aider aujourd'hui ?";
        }
        
        // Help requests
        if (preg_match('/(aide|help|comment|aidez)/', $message)) {
            return "Je peux vous aider avec :\n• Créer une mission\n• Postuler à une mission\n• Gérer vos candidatures\n• Informations sur la plateforme\nQue souhaitez-vous savoir ?";
        }
        
        // Mission creation
        if (preg_match('/(créer|mission|nouvelle|ajouter)/', $message)) {
            return "Pour créer une mission :\n1. Allez dans la section 'Mes Missions'\n2. Cliquez sur 'Nouvelle Mission'\n3. Remplissez le formulaire avec les détails\n4. Publiez votre mission\nBesoin d'aide pour une étape spécifique ?";
        }
        
        // Applications
        if (preg_match('/(postuler|candidature|appliquer)/', $message)) {
            return "Pour postuler à une mission :\n1. Parcourez les missions disponibles\n2. Cliquez sur celle qui vous intéresse\n3. Cliquez sur 'Postuler'\n4. Envoyez votre proposition\nJe peux vous aider à trouver des missions adaptées à vos compétences !";
        }
        
        // Platform info
        if (preg_match('/(work wave|plateforme|site)/', $message)) {
            return "Work Wave est une plateforme de missions freelances où :\n• Les entreprises publient des missions\n• Les freelances postulent et travaillent\n• Tout est géré en ligne\n• Paiement sécurisé et suivi simple\nVous avez d'autres questions sur la plateforme ?";
        }
        
        // Payment
        if (preg_match('/(paiement|payer|argent|prix)/', $message)) {
            return "Concernant les paiements :\n• Les paiements sont sécurisés via la plateforme\n• Vous êtes payé après validation du travail\n• Les délais de paiement sont de 7-14 jours\n• Plusieurs méthodes de paiement disponibles\nBesoin de détails sur un aspect spécifique ?";
        }
        
        // Default response
        return "Je comprends votre demande. Pour une aide plus personnalisée, n'hésitez pas à consulter notre centre d'aide ou contacter directement le support technique. Y a-t-il autre chose que je puisse faire pour vous ?";
    }
}
