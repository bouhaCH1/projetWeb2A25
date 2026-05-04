<?php
require_once __DIR__ . '/../config.php';

class AIService {
    private static $model = 'gemini-2.5-flash-lite';

    /**
     * Classifies a mission based on its title and description.
     * Returns a JSON with suggested category and level.
     */
    public static function classifyMission($title, $description) {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/" . self::$model . ":generateContent?key=" . GEMINI_API_KEY;


        $prompt = "You are a professional HR assistant. Based on the following mission title and description, suggest the most appropriate category, seniority level, and extract a list of 3 to 5 key skills required.
        
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
        Example: {\"categorie\": \"developpement\", \"niveau\": \"intermediaire\", \"competences\": \"PHP, React, MySQL\"}";

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL verification for local dev
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("AIService Curl Error: " . $error);
            return ['error' => 'Connection error: ' . $error];
        }

        error_log("AIService Response: " . $response);
        $result = json_decode($response, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $jsonText = $result['candidates'][0]['content']['parts'][0]['text'];
            // Clean up Markdown JSON blocks if present
            $jsonText = preg_replace('/```json|```/', '', $jsonText);
            return json_decode(trim($jsonText), true);
        }

        return ['error' => 'Unexpected AI response format', 'details' => $result];
    }
}
