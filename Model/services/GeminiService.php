<?php

class GeminiService {
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models';
    /** Derniere erreur transport (cURL / SSL), utile pour le debug */
    private string $lastError = '';
    private bool $skipSslVerify;

    public function __construct(?string $apiKey = null, ?string $model = null) {
        $cfg = is_file(__DIR__ . '/../../config/api.php') ? require __DIR__ . '/../../config/api.php' : [];
        if ($apiKey !== null && $apiKey !== '') {
            $this->apiKey = $apiKey;
        } else {
            $k = (string)($cfg['gemini']['key'] ?? '');
            if ($k === '') {
                $env = getenv('GEMINI_API_KEY');
                $k   = ($env !== false && $env !== '') ? $env : '';
            }
            $this->apiKey = $k;
        }
        $this->model           = $model ?? ($cfg['gemini']['model'] ?? 'gemini-flash-latest');
        $this->skipSslVerify   = !empty($cfg['gemini']['skip_ssl_verify']);
    }

    public function isConfigured(): bool { return $this->apiKey !== ''; }

    public function getLastError(): string { return $this->lastError; }

    public function genererDescriptionFormation(string $titre, string $niveau = 'debutant', string $lieu = ''): string {
        $prompt = "Redige une description pedagogique en francais (environ 80 a 120 mots), un seul paragraphe, phrases completes jusqu au point final.\n"
                . "Titre : {$titre}\nNiveau : {$niveau}\n"
                . ($lieu ? "Lieu : {$lieu}\n" : '')
                . "Ton professionnel, sans markdown ni liste a puces. Ne coupe pas une phrase a mi mot.";
        return $this->complete($prompt) ?: "Formation {$titre} (niveau {$niveau}). Decrivez ici les objectifs et le contenu.";
    }

    public function complete(string $prompt): ?string {
        if (!$this->isConfigured()) {
            return null;
        }
        $this->lastError = '';
        $url     = $this->baseUrl . '/' . rawurlencode($this->model) . ':generateContent';
        $payload = [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
            'generationConfig' => [
                'temperature'       => 0.75,
                'maxOutputTokens'   => 2048,
            ],
        ];
        $body    = json_encode($payload);
        $headers = [
            'Content-Type'   => 'application/json',
            'X-goog-api-key' => $this->apiKey,
        ];

        $raw = $this->requestPost($url, $body, $headers);
        if ($raw === null) {
            return null;
        }
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            $this->lastError = 'Reponse JSON invalide.';
            return null;
        }
        if (!empty($data['error']['message'])) {
            $this->lastError = (string)$data['error']['message'];
            return null;
        }
        $parts = $data['candidates'][0]['content']['parts'] ?? null;
        if (!is_array($parts) || $parts === []) {
            $this->lastError = 'Reponse Gemini sans texte (blocage ou quota).';
            return null;
        }
        $chunks = [];
        foreach ($parts as $p) {
            if (is_array($p) && isset($p['text']) && $p['text'] !== '') {
                $chunks[] = $p['text'];
            }
        }
        if ($chunks === []) {
            $this->lastError = 'Reponse Gemini sans texte (blocage ou quota).';
            return null;
        }
        return trim(implode('', $chunks));
    }

    /** @param array<string,string> $headers */
    private function requestPost(string $url, string $body, array $headers): ?string {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            $hdrLines = [];
            foreach ($headers as $k => $v) {
                $hdrLines[] = $k . ': ' . $v;
            }
            $opts = [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $body,
                CURLOPT_HTTPHEADER     => $hdrLines,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 45,
                CURLOPT_CONNECTTIMEOUT => 15,
            ];
            if ($this->skipSslVerify) {
                $opts[CURLOPT_SSL_VERIFYPEER] = false;
                $opts[CURLOPT_SSL_VERIFYHOST] = 0;
            }
            curl_setopt_array($ch, $opts);
            $raw = curl_exec($ch);
            $no  = curl_errno($ch);
            $err = curl_error($ch);
            curl_close($ch);
            if ($no !== 0) {
                $this->lastError = $err !== '' ? $err : ('cURL #' . (string)$no);
                return null;
            }
            return $raw !== false ? $raw : null;
        }

        $headerStr = '';
        foreach ($headers as $k => $v) {
            $headerStr .= $k . ': ' . $v . "\r\n";
        }
        $ssl = [];
        if ($this->skipSslVerify) {
            $ssl['verify_peer']      = false;
            $ssl['verify_peer_name'] = false;
        }
        $ctx = stream_context_create([
            'http' => [
                'method'        => 'POST',
                'header'        => $headerStr,
                'content'       => $body,
                'timeout'       => 45,
                'ignore_errors' => true,
            ],
            'ssl'  => $ssl,
        ]);
        $raw = @file_get_contents($url, false, $ctx);
        if ($raw === false) {
            $this->lastError = 'file_get_contents a echoue (allow_url_fopen ou SSL). Activez l\'extension cURL en priorite.';
            return null;
        }
        return $raw;
    }
}
