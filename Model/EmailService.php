<?php
require_once __DIR__ . '/config.php';

class EmailService {
    private static $model = 'gemini-flash-latest';

    /**
     * Génère un email personnalisé pour un candidat (Acceptation ou Refus).
     * Retourne un tableau avec sujet et corps de l'email.
     */
    public static function generateEmail($type, $candidateName, $missionTitle, $motivation = '') {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/" . self::$model . ":generateContent?key=" . GEMINI_API_KEY;

        if ($type === 'acceptation') {
            $instruction = "Rédige un email professionnel en français pour informer un candidat qu'il a été accepté pour une mission freelance.";
            $tone = "enthousiaste et professionnel";
            $closing = "Félicitations encore et bienvenue dans l'équipe !";
            $style = "chaleureux et accueillant";
        } else {
            $instruction = "Rédige un email professionnel en français pour informer formellement un candidat que sa candidature est REFUSÉE et qu'il n'a PAS été retenu pour la mission freelance.";
            $tone = "respectueux mais ferme sur le refus";
            $closing = "Nous vous souhaitons beaucoup de succès dans vos projets futurs.";
            $style = "professionnel et direct, annonçant clairement le refus";
        }

        $prompt = "$instruction

        Détails :
        - Nom du candidat : $candidateName
        - Titre de la mission : $missionTitle
        - Ton : $tone

        Instructions de formatage :
        - Commence directement par le sujet sous la forme : SUJET: [sujet de l'email]
        - Ensuite, rédige le corps de l'email de manière structurée avec des paragraphes clairs.
        - Finis par : CLOSING: [votre phrase de fermeture]
        - L'email ne doit pas dépasser 150 mots.
        - Le style doit être $style.";

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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("EmailService Curl Error: " . $error);
            // Return fallback instead of error
            return self::getFallbackEmail($type, $candidateName, $missionTitle);
        }

        $result = json_decode($response, true);
        error_log("EmailService Response: " . json_encode($result));

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $result['candidates'][0]['content']['parts'][0]['text'];
            $parsed = self::parseEmail($text, $type, $candidateName, $missionTitle);
            // If parsing failed, use fallback
            if (empty($parsed['sujet']) || empty($parsed['corps'])) {
                error_log("EmailService parsing failed, using fallback");
                return self::getFallbackEmail($type, $candidateName, $missionTitle);
            }
            return $parsed;
        }

        error_log("EmailService: Unexpected response, using fallback");
        return self::getFallbackEmail($type, $candidateName, $missionTitle);
    }

    private static function getFallbackEmail($type, $candidateName, $missionTitle) {
        if ($type === 'acceptation') {
            return [
                'sujet' => "Félicitations $candidateName — Votre candidature pour '$missionTitle' a été retenue",
                'corps' => "Bonjour $candidateName,\n\nNous avons le plaisir de vous informer que votre candidature pour la mission '$missionTitle' a été retenue. Votre profil correspond parfaitement aux attentes de notre client.\n\nNous allons vous contacter rapidement pour les prochaines étapes.\n\nCordialement,\nL'équipe Work Wave",
                'fermeture' => "Félicitations encore et bienvenue dans l'équipe !",
                'type' => $type
            ];
        } else {
            return [
                'sujet' => "Suivi de votre candidature — $missionTitle",
                'corps' => "Bonjour $candidateName,\n\nNous vous remercions pour l'intérêt que vous portez à la mission '$missionTitle'. Après avoir étudié attentivement votre candidature, nous avons décidé de ne pas retenir votre profil pour ce projet.\n\nNous vous encourageons à postuler à d'autres missions qui correspondent davantage à votre profil.\n\nCordialement,\nL'équipe Work Wave",
                'fermeture' => "Je vous souhaite beaucoup de succès dans vos projets futurs.",
                'type' => $type
            ];
        }
    }

    private static function parseEmail($text, $type, $candidateName, $missionTitle) {
        // Fallback si parsing echoue
        $defaultSubject = $type === 'acceptation'
            ? "Félicitations $candidateName — Votre candidature pour '$missionTitle' a été retenue"
            : "Suivi de votre candidature — $missionTitle";

        $defaultBody = $type === 'acceptation'
            ? "Bonjour $candidateName,\n\nNous avons le plaisir de vous informer que votre candidature pour la mission '$missionTitle' a été retenue. Votre profil correspond parfaitement aux attentes de notre client.\n\nNous allons vous contacter rapidement pour les prochaines étapes.\n\nCordialement,\nL'équipe Work Wave"
            : "Bonjour $candidateName,\n\nNous vous remercions pour l'intérêt que vous portez à la mission '$missionTitle'. Après avoir étudié attentivement votre candidature, nous avons décidé de ne pas retenir votre profil pour ce projet.\n\nNous vous encourageons à postuler à d'autres missions qui correspondent davantage à votre profil.\n\nCordialement,\nL'équipe Work Wave";

        // Extract SUJET
        $subject = $defaultSubject;
        if (preg_match('/SUJET:\s*(.+)(?:\n|$)/i', $text, $m)) {
            $subject = trim($m[1]);
        }

        // Extract CLOSING
        $closing = '';
        if (preg_match('/CLOSING:\s*(.+)(?:\n|$)/i', $text, $m)) {
            $closing = trim($m[1]);
        }

        // Extract body (entre SUJET et CLOSING)
        $body = $defaultBody;
        if (preg_match('/SUJET:.+\n(.+)CLOSING:/is', $text, $m)) {
            $body = trim($m[1]);
        } elseif (preg_match('/SUJET:.+\n(.+)/is', $text, $m)) {
            $body = trim($m[1]);
        }

        // Nettoyer les backticks markdown
        $body = preg_replace('/```[\w]*\n?|\n?```/', '', $body);
        $subject = preg_replace('/```[\w]*\n?|\n?```/', '', $subject);
        $closing = preg_replace('/```[\w]*\n?|\n?```/', '', $closing);

        return [
            'sujet' => $subject,
            'corps' => $body,
            'fermeture' => $closing,
            'type' => $type
        ];
    }
}
