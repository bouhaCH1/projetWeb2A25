<?php

/**
 * WorkWave — Email Mailer via Brevo API
 * Sends real transactional emails using the Brevo (ex-Sendinblue) API.
 */

// ============================================================
// CONFIGURATION
// ============================================================
if (file_exists(__DIR__ . '/api_keys.php')) {
    require_once __DIR__ . '/api_keys.php';
} else {
    define('BREVO_API_KEY',   'VOTRE_CLE_API_BREVO_ICI');
}
define('BREVO_FROM_EMAIL','chaabenbeha@gmail.com');
define('BREVO_FROM_NAME', 'WorkWave');
// ============================================================

// Optional: HuggingFace API token for real AI analysis
// Get a free token at https://huggingface.co/settings/tokens
if (!defined('HUGGINGFACE_API_TOKEN')) {
    define('HUGGINGFACE_API_TOKEN', '');
}
// ============================================================

class SmtpMailer {

    /**
     * Send an email via Brevo API.
     * @return array ['success' => bool, 'message' => string]
     */
    public static function sendEmail(
        string $toEmail,
        string $toName,
        string $subject,
        string $bodyText
    ): array {

        $payload = json_encode([
            'sender'      => [
                'name'  => BREVO_FROM_NAME,
                'email' => BREVO_FROM_EMAIL,
            ],
            'to'          => [
                ['email' => $toEmail, 'name' => $toName]
            ],
            'subject'     => $subject,
            'textContent' => $bodyText,
        ]);

        $ch = curl_init('https://api.brevo.com/v3/smtp/email');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER     => [
                'accept: application/json',
                'api-key: ' . BREVO_API_KEY,
                'content-type: application/json',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            return ['success' => false, 'message' => 'cURL error: ' . $curlErr];
        }

        // Brevo returns 201 on success
        if ($httpCode === 201) {
            return ['success' => true, 'message' => "Email envoyé à $toEmail"];
        }

        $decoded = json_decode($response, true);
        $errMsg  = $decoded['message'] ?? $response;
        return ['success' => false, 'message' => "Brevo API error ($httpCode): $errMsg"];
    }

    // ── Static helpers used by UserController & User model ──────────────

    public static function sendOTP(string $toEmail, string $firstName, string $code): bool {
        $subject = 'WorkWave — Votre code de double authentification';
        $body    = "Bonjour $firstName,\n\n";
        $body   .= "Votre code de sécurité WorkWave est :\n\n";
        $body   .= "        $code\n\n";
        $body   .= "Ce code est valide pendant 5 minutes.\n";
        $body   .= "Si vous n'avez pas demandé ce code, ignorez cet email.\n\n";
        $body   .= "L'équipe WorkWave";

        $result = self::sendEmail($toEmail, $firstName, $subject, $body);
        return $result['success'];
    }

    public static function sendWelcome(string $toEmail, string $firstName): bool {
        $subject = 'Bienvenue sur WorkWave !';
        $body    = "Bonjour $firstName,\n\n";
        $body   .= "Bienvenue sur WorkWave !\n\n";
        $body   .= "Votre compte a été créé avec succès.\n";
        $body   .= "Vous pouvez maintenant vous connecter et explorer toutes nos fonctionnalités.\n\n";
        $body   .= "Bonne découverte !\n\nL'équipe WorkWave";

        $result = self::sendEmail($toEmail, $firstName, $subject, $body);
        return $result['success'];
    }

    public static function sendPasswordReset(string $toEmail, string $firstName, string $resetLink): bool {
        $subject = 'WorkWave — Réinitialisation de votre mot de passe';
        $body    = "Bonjour $firstName,\n\n";
        $body   .= "Vous avez demandé une réinitialisation de mot de passe.\n\n";
        $body   .= "Cliquez sur le lien ci-dessous :\n";
        $body   .= "$resetLink\n\n";
        $body   .= "Ce lien expirera dans 1 heure.\n\n";
        $body   .= "Si vous n'avez pas fait cette demande, ignorez cet email.\n\n";
        $body   .= "L'équipe WorkWave";

        $result = self::sendEmail($toEmail, $firstName, $subject, $body);
        return $result['success'];
    }

    // Legacy compatibility — some old calls use send() instance method
    public function send(string $toEmail, string $toName, string $subject, string $bodyText): array {
        return self::sendEmail($toEmail, $toName, $subject, $bodyText);
    }
}
