<?php
class BadWordsService {
    private array $cfg;

    public function __construct() {
        $this->cfg = require __DIR__ . '/../../config/api.php';
    }

    // Retourne le texte avec les mots inappropries remplaces par ***
    public function filter(string $text): string {
        if (!$this->cfg['badwords']['enabled'] || !trim($text)) return $text;
        return $this->callApi($text) ?: $text;
    }

    // Retourne true si le texte contient des mots inappropries
    public function contains(string $text): bool {
        if (!trim($text)) return false;
        $filtered = $this->filter($text);
        return $filtered !== $text;
    }

    private function callApi(string $text): string {
        $url = $this->cfg['badwords']['url'] . '?text=' . urlencode($text);
        $ctx = stream_context_create(['http' => ['timeout' => 5, 'ignore_errors' => true]]);
        $resp = @file_get_contents($url, false, $ctx);
        if (!$resp) return $text;

        $data = json_decode($resp, true);
        // PurgoMalum retourne {"result":"texte filtre"} ou {"error":"..."}
        if (isset($data['result'])) return $data['result'];
        return $text;
    }
}
