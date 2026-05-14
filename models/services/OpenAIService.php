<?php

class OpenAIService {
    private string $apiKey;
    private string $model;
    private string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct(?string $apiKey = null, string $model = 'gpt-4o-mini') {
        $cfg          = is_file(__DIR__ . '/../../config/api.php') ? require __DIR__ . '/../../config/api.php' : [];
        $this->apiKey = $apiKey ?? ($cfg['openai']['key'] ?? (getenv('OPENAI_API_KEY') ?: ''));
        $this->model  = $model;
    }

    public function isConfigured(): bool { return $this->apiKey !== ''; }

    public function genererDescriptionFormation(string $titre, string $niveau = 'debutant', string $lieu = ''): string {
        $prompt = "Redige une description pedagogique en francais (environ 80 a 120 mots), un seul paragraphe, phrases completes jusqu au point final.\n"
                . "Titre : {$titre}\nNiveau : {$niveau}\n"
                . ($lieu ? "Lieu : {$lieu}\n" : '')
                . "Ton professionnel, sans markdown ni liste a puces. Ne coupe pas une phrase a mi mot.";
        return $this->complete($prompt) ?: "Formation {$titre} (niveau {$niveau}). Decrivez ici les objectifs et le contenu.";
    }

    public function complete(string $prompt): ?string {
        if (!$this->isConfigured()) return null;
        $payload = [
            'model'    => $this->model,
            'messages' => [['role'=>'user','content'=>$prompt]],
            'temperature' => 0.7,
            'max_tokens'  => 900,
        ];
        $ctx = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\nAuthorization: Bearer {$this->apiKey}\r\n",
                'content' => json_encode($payload),
                'timeout' => 12,
                'ignore_errors' => true,
            ],
        ]);
        $raw = @file_get_contents($this->endpoint, false, $ctx);
        if (!$raw) return null;
        $data = json_decode($raw, true);
        return $data['choices'][0]['message']['content'] ?? null;
    }
}
