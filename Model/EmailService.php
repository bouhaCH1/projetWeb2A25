<?php
require_once __DIR__ . '/config.php';

class EmailService {
    private static $model = 'gemini-1.5-flash';

    /**
     * Génère ET ENVOIE un email au candidat.
     * Retourne un tableau avec sujet, corps et statut d'envoi.
     */
    public static function generateAndSendEmail($type, $toEmail, $candidateName, $missionTitle, $motivation = '') {
        // 1. Générer l'email (avec fallback si Gemini indisponible)
        $email = self::generateEmail($type, $candidateName, $missionTitle, $motivation);
        
        // 2. Envoyer via Resend
        $sent = self::sendViaResend($toEmail, $email['sujet'], $email['corps']);
        
        return [
            'sujet' => $email['sujet'],
            'corps' => $email['corps'],
            'fermeture' => $email['fermeture'],
            'type' => $email['type'],
            'sent' => $sent,
            'recipient' => $toEmail
        ];
    }

    /**
     * Envoi via Resend.com
     */
    private static function sendViaResend($to, $subject, $body) {
        if (!defined('RESEND_API_KEY') || empty(RESEND_API_KEY)) {
            error_log("Resend API key not configured");
            return false;
        }
        
        $data = [
            'from' => 'onboarding@resend.dev',
            'to' => [$to],
            'subject' => $subject,
            'html' => self::getEmailTemplate($body),
            'text' => $body
        ];
        
        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . RESEND_API_KEY,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if ($httpCode >= 200 && $httpCode < 300 && isset($result['id'])) {
            error_log("Email SENT to $to, ID: " . $result['id']);
            return true;
        }
        
        error_log("Resend failed: " . $response);
        return false;
    }

    /**
     * Template HTML pour les emails
     */
    private static function getEmailTemplate($body) {
        $body = nl2br(htmlspecialchars($body));
        return "<!DOCTYPE html><html><head><meta charset='UTF-8'><style>body{font-family:Arial,sans-serif;line-height:1.6;color:#333;}.container{max-width:600px;margin:0 auto;padding:20px;}.header{background:linear-gradient(135deg,#00ffcc,#00ccff);padding:30px;text-align:center;border-radius:10px 10px 0 0;}.header h1{color:#0a0e27;margin:0;font-size:24px;}.content{background:#f8f9fa;padding:30px;border-radius:0 0 10px 10px;}.footer{text-align:center;padding:20px;color:#666;font-size:12px;}</style></head><body><div class='container'><div class='header'><h1>🌊 Work Wave</h1></div><div class='content'>$body</div><div class='footer'><p>© 2025 Work Wave</p></div></div></body></html>";
    }

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
                error_log("EmailService Curl Error (Attempt " . ($attempts+1) . "): " . $error);
            } elseif ($httpCode === 200) {
                break;
            } elseif ($httpCode === 429 || $httpCode === 503) {
                error_log("EmailService API Error $httpCode (Attempt " . ($attempts+1) . "): " . $response);
                $attempts++;
                if ($attempts < $maxAttempts) {
                    sleep(1);
                    continue;
                }
            } else {
                error_log("EmailService Unexpected Error $httpCode: " . $response);
                break;
            }
            $attempts++;
        }

        if ($httpCode === 200 && $response) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $text = $result['candidates'][0]['content']['parts'][0]['text'];
                $parsed = self::parseEmail($text, $type, $candidateName, $missionTitle);
                if (!empty($parsed['sujet']) && !empty($parsed['corps'])) {
                    return $parsed;
                }
            }
        }

        error_log("EmailService: Using fallback email");
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
        $defaultSubject = $type === 'acceptation'
            ? "Félicitations $candidateName — Votre candidature pour '$missionTitle' a été retenue"
            : "Suivi de votre candidature — $missionTitle";

        $defaultBody = $type === 'acceptation'
            ? "Bonjour $candidateName,\n\nNous avons le plaisir de vous informer que votre candidature pour la mission '$missionTitle' a été retenue. Votre profil correspond parfaitement aux attentes de notre client.\n\nNous allons vous contacter rapidement pour les prochaines étapes.\n\nCordialement,\nL'équipe Work Wave"
            : "Bonjour $candidateName,\n\nNous vous remercions pour l'intérêt que vous portez à la mission '$missionTitle'. Après avoir étudié attentivement votre candidature, nous avons décidé de ne pas retenir votre profil pour ce projet.\n\nNous vous encourageons à postuler à d'autres missions qui correspondent davantage à votre profil.\n\nCordialement,\nL'équipe Work Wave";

        $subject = $defaultSubject;
        if (preg_match('/SUJET:\s*(.+)(?:\n|$)/i', $text, $m)) {
            $subject = trim($m[1]);
        }

        $closing = '';
        if (preg_match('/CLOSING:\s*(.+)(?:\n|$)/i', $text, $m)) {
            $closing = trim($m[1]);
        }

        $body = $defaultBody;
        if (preg_match('/SUJET:.+\n(.+)CLOSING:/is', $text, $m)) {
            $body = trim($m[1]);
        } elseif (preg_match('/SUJET:.+\n(.+)/is', $text, $m)) {
            $body = trim($m[1]);
        }

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
