<?php
require_once __DIR__ . '/../../Model/config/database.php';

class TranslationService {

    private PDO $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getSupportedLanguages(): array {
        return [
            'ar' => 'Arabe',
            'en' => 'Anglais',
            'fr' => 'Français',
        ];
    }

    public function translate(string $text, string $targetLang = 'en', string $sourceLang = 'fr'): string {
        $text = trim($text);
        if (!$text) return $text;

        $hash = md5($text);

        // Cache lookup
        $s = $this->db->prepare(
            "SELECT traduction FROM traductions WHERE source_hash=? AND source_lang=? AND target_lang=?"
        );
        $s->execute([$hash, $sourceLang, $targetLang]);
        if ($cached = $s->fetchColumn()) return $cached;

        $translated = $this->callMyMemory($text, $sourceLang, $targetLang);
        if ($translated && $translated !== $text) {
            $ins = $this->db->prepare(
                "INSERT IGNORE INTO traductions (source_hash, source_lang, target_lang, traduction) VALUES(?,?,?,?)"
            );
            $ins->execute([$hash, $sourceLang, $targetLang, $translated]);
        }

        return $translated ?: $text;
    }

    private function callMyMemory(string $text, string $from, string $to): string {
        $langPair = "{$from}|{$to}";
        $url = 'https://api.mymemory.translated.net/get'
             . '?q=' . urlencode($text)
             . '&langpair=' . urlencode($langPair);

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 8,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT      => 'FormationPHP/1.0',
            ]);
            $resp = curl_exec($ch);
            $err  = curl_error($ch);
            curl_close($ch);
            if ($err || !$resp) return '';
        } else {
            $ctx  = stream_context_create(['http' => [
                'timeout'       => 8,
                'ignore_errors' => true,
                'user_agent'    => 'FormationPHP/1.0',
            ]]);
            $resp = @file_get_contents($url, false, $ctx);
            if (!$resp) return '';
        }

        $data = json_decode($resp, true);
        if (!$data) return '';

        $translated = $data['responseData']['translatedText'] ?? '';

        // MyMemory returns the original text when it can't translate
        if (!$translated || strtolower($translated) === strtolower($text)) return '';

        // MyMemory sometimes returns "QUERY LENGTH LIMIT EXCEEDED" etc.
        if (str_starts_with(strtoupper($translated), 'QUERY')) return '';

        return $translated;
    }
}
