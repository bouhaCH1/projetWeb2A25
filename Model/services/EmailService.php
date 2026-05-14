<?php
class EmailService {
    private array $cfg;

    public function __construct() {
        $this->cfg = require __DIR__ . '/../../config/email.php';
    }

    public function sendFormationCreee(array $formation, string $toEmail, string $toName): bool {
        $subject = "Nouvelle formation : {$formation['titre']}";
        $body    = $this->templateFormation($formation, $toName);
        return $this->send($toEmail, $toName, $subject, $body);
    }

    public function sendTacheAjoutee(array $tache, array $formation, string $toEmail, string $toName): bool {
        $subject = "Nouvelle tache dans : {$formation['titre']}";
        $body    = $this->templateTache($tache, $formation, $toName);
        return $this->send($toEmail, $toName, $subject, $body);
    }

    public function send(string $to, string $toName, string $subject, string $htmlBody): bool {
        if (!$this->cfg['enabled']) return false;

        $secure = strtolower($this->cfg['secure'] ?? '');
        $host   = $this->cfg['host'];
        $port   = (int)$this->cfg['port'];

        $socket = match($secure) {
            'ssl'   => @fsockopen("ssl://{$host}", $port, $errno, $errstr, 10),
            default => @fsockopen($host, $port, $errno, $errstr, 10),
        };

        if (!$socket) return false;

        try {
            $this->expect($socket, '220');
            $this->cmd($socket, "EHLO localhost");
            $resp = $this->readAll($socket);

            if ($secure === 'tls') {
                $this->cmd($socket, "STARTTLS");
                $this->expect($socket, '220');
                stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                $this->cmd($socket, "EHLO localhost");
                $this->readAll($socket);
            }

            $this->cmd($socket, "AUTH LOGIN");
            $this->expect($socket, '334');
            $this->cmd($socket, base64_encode($this->cfg['username']));
            $this->expect($socket, '334');
            $this->cmd($socket, base64_encode($this->cfg['password']));
            $this->expect($socket, '235');

            $this->cmd($socket, "MAIL FROM:<{$this->cfg['from']}>");
            $this->expect($socket, '250');
            $this->cmd($socket, "RCPT TO:<{$to}>");
            $this->expect($socket, '250');
            $this->cmd($socket, "DATA");
            $this->expect($socket, '354');

            $boundary = md5(uniqid());
            $headers  = implode("\r\n", [
                "From: {$this->cfg['from_name']} <{$this->cfg['from']}>",
                "To: {$toName} <{$to}>",
                "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=",
                "MIME-Version: 1.0",
                "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
                "Date: " . date('r'),
            ]);

            $text = strip_tags($htmlBody);
            $msg  = $headers . "\r\n\r\n"
                  . "--{$boundary}\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n{$text}\r\n"
                  . "--{$boundary}\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n{$htmlBody}\r\n"
                  . "--{$boundary}--";

            fwrite($socket, $msg . "\r\n.\r\n");
            $this->expect($socket, '250');
            $this->cmd($socket, "QUIT");
        } catch (\Exception $e) {
            fclose($socket);
            error_log("EmailService: " . $e->getMessage());
            return false;
        }

        fclose($socket);
        return true;
    }

    private function cmd($socket, string $cmd): void {
        fwrite($socket, $cmd . "\r\n");
    }

    private function expect($socket, string $code): void {
        $resp = fgets($socket, 512);
        if (!str_starts_with(trim($resp), $code)) {
            throw new \RuntimeException("SMTP attendait {$code}, recu: {$resp}");
        }
    }

    private function readAll($socket): string {
        $out = '';
        while ($line = fgets($socket, 512)) {
            $out .= $line;
            if (substr($line, 3, 1) === ' ') break;
        }
        return $out;
    }

    private function templateFormation(array $f, string $name): string {
        $titre  = htmlspecialchars($f['titre']);
        $lieu   = htmlspecialchars($f['lieu'] ?? '');
        $niveau = htmlspecialchars($f['niveau'] ?? '');
        $debut  = $f['date_debut'] ?? '';
        $fin    = $f['date_fin']   ?? '';
        return <<<HTML
        <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden">
          <div style="background:#1a76d1;padding:24px;color:#fff">
            <h2 style="margin:0">FormationPHP</h2>
            <p style="margin:4px 0 0">Nouvelle formation disponible</p>
          </div>
          <div style="padding:24px">
            <p>Bonjour <strong>{$name}</strong>,</p>
            <p>Une nouvelle formation vient d'etre creee :</p>
            <table style="width:100%;border-collapse:collapse">
              <tr><td style="padding:8px;font-weight:bold;color:#555">Titre</td><td style="padding:8px">{$titre}</td></tr>
              <tr style="background:#f9f9f9"><td style="padding:8px;font-weight:bold;color:#555">Lieu</td><td style="padding:8px">{$lieu}</td></tr>
              <tr><td style="padding:8px;font-weight:bold;color:#555">Niveau</td><td style="padding:8px">{$niveau}</td></tr>
              <tr style="background:#f9f9f9"><td style="padding:8px;font-weight:bold;color:#555">Du</td><td style="padding:8px">{$debut}</td></tr>
              <tr><td style="padding:8px;font-weight:bold;color:#555">Au</td><td style="padding:8px">{$fin}</td></tr>
            </table>
          </div>
          <div style="background:#f5f5f5;padding:16px;text-align:center;color:#999;font-size:12px">FormationPHP &mdash; Systeme de gestion des formations</div>
        </div>
        HTML;
    }

    private function templateTache(array $t, array $f, string $name): string {
        $titre      = htmlspecialchars($t['titre']);
        $formation  = htmlspecialchars($f['titre']);
        $duree      = (int)($t['duree'] ?? 0);
        $debut      = $t['date_debut'] ?? '';
        $fin        = $t['date_fin']   ?? '';
        return <<<HTML
        <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden">
          <div style="background:#00b894;padding:24px;color:#fff">
            <h2 style="margin:0">FormationPHP</h2>
            <p style="margin:4px 0 0">Nouvelle tache ajoutee</p>
          </div>
          <div style="padding:24px">
            <p>Bonjour <strong>{$name}</strong>,</p>
            <p>Une nouvelle tache a ete ajoutee a la formation <strong>{$formation}</strong> :</p>
            <table style="width:100%;border-collapse:collapse">
              <tr><td style="padding:8px;font-weight:bold;color:#555">Tache</td><td style="padding:8px">{$titre}</td></tr>
              <tr style="background:#f9f9f9"><td style="padding:8px;font-weight:bold;color:#555">Duree</td><td style="padding:8px">{$duree}h</td></tr>
              <tr><td style="padding:8px;font-weight:bold;color:#555">Du</td><td style="padding:8px">{$debut}</td></tr>
              <tr style="background:#f9f9f9"><td style="padding:8px;font-weight:bold;color:#555">Au</td><td style="padding:8px">{$fin}</td></tr>
            </table>
          </div>
          <div style="background:#f5f5f5;padding:16px;text-align:center;color:#999;font-size:12px">FormationPHP &mdash; Systeme de gestion des formations</div>
        </div>
        HTML;
    }
}
