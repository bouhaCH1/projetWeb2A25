<?php

/**
 * WorkWave — Pure PHP SMTP Mailer
 * Sends email via Gmail (or any SMTP) using raw socket — no external library needed.
 *
 * HOW TO SET UP (takes 2 minutes):
 * 1. Go to your Google Account → Security → App Passwords
 *    (You need 2-Step Verification enabled first)
 * 2. Create an App Password for "Mail" / "Windows Computer"
 * 3. Copy the 16-character password (no spaces) into SMTP_PASSWORD below
 * 4. Set SMTP_USERNAME to your Gmail address
 * 5. That's it! Emails will work.
 */

// ============================================================
// CONFIGURATION — Fill in your Gmail credentials here
// ============================================================
define('SMTP_HOST',     'smtp.gmail.com');
define('SMTP_PORT',     587);               // TLS port
define('SMTP_USERNAME', '');                // Your Gmail: example@gmail.com
define('SMTP_PASSWORD', '');               // Gmail App Password (16 chars)
define('SMTP_FROM',     'noreply@workwave.com');
define('SMTP_FROM_NAME','WorkWave');

// Optional: HuggingFace API token for real AI analysis
// Get a free token at https://huggingface.co/settings/tokens
define('HUGGINGFACE_API_TOKEN', '');
// ============================================================

class SmtpMailer {

    private string $host;
    private int    $port;
    private string $username;
    private string $password;

    public function __construct(
        string $host     = SMTP_HOST,
        int    $port     = SMTP_PORT,
        string $username = SMTP_USERNAME,
        string $password = SMTP_PASSWORD
    ) {
        $this->host     = $host;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Send an email.
     * @return array ['success' => bool, 'message' => string]
     */
    public function send(string $toEmail, string $toName, string $subject, string $bodyText): array {
        // If no credentials configured, skip real send
        if (empty($this->username) || empty($this->password)) {
            return ['success' => false, 'message' => 'SMTP non configuré (voir Model/SmtpMailer.php)'];
        }

        try {
            // Open socket connection
            $errno  = 0;
            $errstr = '';
            $socket = @fsockopen('tls://' . $this->host, 465, $errno, $errstr, 10);

            // Try port 587 with TLS if 465 fails
            if (!$socket) {
                $socket = @stream_socket_client(
                    'tcp://' . $this->host . ':' . $this->port,
                    $errno, $errstr, 10
                );
                if ($socket) {
                    $this->read($socket); // greeting
                    $this->cmd($socket, "EHLO workwave.local");
                    // Start TLS
                    $this->cmd($socket, "STARTTLS");
                    stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                }
            } else {
                $this->read($socket); // greeting on SSL
            }

            if (!$socket) {
                return ['success' => false, 'message' => "Impossible de se connecter au serveur SMTP ($errstr)"];
            }

            // EHLO after TLS
            $this->cmd($socket, "EHLO workwave.local");

            // AUTH LOGIN
            $this->cmd($socket, "AUTH LOGIN");
            $this->cmd($socket, base64_encode($this->username));
            $authResp = $this->cmd($socket, base64_encode($this->password));

            if (strpos($authResp, '235') === false) {
                fclose($socket);
                return ['success' => false, 'message' => 'Authentification SMTP échouée. Vérifiez vos identifiants.'];
            }

            // FROM / TO / DATA
            $this->cmd($socket, "MAIL FROM:<" . SMTP_FROM . ">");
            $this->cmd($socket, "RCPT TO:<$toEmail>");
            $this->cmd($socket, "DATA");

            $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
            $encodedFrom    = '=?UTF-8?B?' . base64_encode(SMTP_FROM_NAME) . '?=';
            $date           = date('r');

            $message  = "Date: $date\r\n";
            $message .= "From: $encodedFrom <" . SMTP_FROM . ">\r\n";
            $message .= "To: $toName <$toEmail>\r\n";
            $message .= "Subject: $encodedSubject\r\n";
            $message .= "MIME-Version: 1.0\r\n";
            $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "\r\n";
            $message .= chunk_split(base64_encode($bodyText));
            $message .= "\r\n.\r\n";

            fputs($socket, $message);
            $dataResp = $this->read($socket);

            $this->cmd($socket, "QUIT");
            fclose($socket);

            if (strpos($dataResp, '250') !== false) {
                return ['success' => true, 'message' => "Email envoyé à $toEmail"];
            } else {
                return ['success' => false, 'message' => "Envoi échoué: $dataResp"];
            }

        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Erreur SMTP: ' . $e->getMessage()];
        }
    }

    private function cmd($socket, string $command): string {
        fputs($socket, $command . "\r\n");
        return $this->read($socket);
    }

    private function read($socket): string {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') break;
        }
        return $response;
    }

    // ---- Convenience static methods ----

    public static function sendOTP(string $toEmail, string $firstName, string $code): bool {
        $subject = 'WorkWave — Votre code de double authentification';
        $body    = "Bonjour $firstName,\n\n";
        $body   .= "Votre code de sécurité WorkWave est :\n\n";
        $body   .= "    ► $code ◄\n\n";
        $body   .= "Ce code est valide pendant 5 minutes.\n";
        $body   .= "Si vous n'avez pas demandé ce code, ignorez cet email.\n\n";
        $body   .= "L'équipe WorkWave";

        $mailer = new self();
        $result = $mailer->send($toEmail, $firstName, $subject, $body);
        return $result['success'];
    }

    public static function sendWelcome(string $toEmail, string $firstName): bool {
        $subject = 'Bienvenue sur WorkWave !';
        $body    = "Bonjour $firstName,\n\n";
        $body   .= "Bienvenue sur WorkWave ! 🎉\n\n";
        $body   .= "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter et explorer toutes nos fonctionnalités.\n\n";
        $body   .= "• Analysez votre profil avec notre IA (HuggingFace)\n";
        $body   .= "• Vérifiez votre identité par OCR\n";
        $body   .= "• Activez la double authentification (2FA)\n\n";
        $body   .= "Bonne découverte !\n\nL'équipe WorkWave";

        $mailer = new self();
        $result = $mailer->send($toEmail, $firstName, $subject, $body);
        return $result['success'];
    }

    public static function sendPasswordReset(string $toEmail, string $firstName, string $resetLink): bool {
        $subject = 'WorkWave — Réinitialisation de votre mot de passe';
        $body    = "Bonjour $firstName,\n\n";
        $body   .= "Vous avez demandé une réinitialisation de mot de passe.\n\n";
        $body   .= "Cliquez sur le lien ci-dessous pour continuer :\n";
        $body   .= "$resetLink\n\n";
        $body   .= "Ce lien expirera dans 1 heure.\n\n";
        $body   .= "Si vous n'avez pas fait cette demande, ignorez cet email.\n\n";
        $body   .= "L'équipe WorkWave";

        $mailer = new self();
        $result = $mailer->send($toEmail, $firstName, $subject, $body);
        return $result['success'];
    }
}
