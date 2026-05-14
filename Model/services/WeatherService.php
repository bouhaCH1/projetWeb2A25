<?php

class WeatherService {
    private string $city;
    private float $lat;
    private float $lon;

    public function __construct(string $city = 'Tunis', float $lat = 36.8065, float $lon = 10.1815) {
        $this->city = $city;
        $this->lat  = $lat;
        $this->lon  = $lon;
    }

    public function current(): ?array {
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$this->lat}&longitude={$this->lon}&current=temperature_2m,weather_code,wind_speed_10m,relative_humidity_2m&timezone=auto";
        $ctx = stream_context_create(['http'=>['timeout'=>4]]);
        $raw = @file_get_contents($url, false, $ctx);
        if (!$raw) return null;
        $data = json_decode($raw, true);
        if (!isset($data['current'])) return null;
        $c = $data['current'];
        return [
            'city'        => $this->city,
            'temperature' => $c['temperature_2m']    ?? null,
            'humidity'    => $c['relative_humidity_2m'] ?? null,
            'wind'        => $c['wind_speed_10m']    ?? null,
            'code'        => $c['weather_code']      ?? null,
            'label'       => self::label($c['weather_code'] ?? null),
            'icon'        => self::icon($c['weather_code'] ?? null),
        ];
    }

    private static function label(?int $c): string {
        return match (true) {
            $c === 0                        => 'Ensoleille',
            $c !== null && $c <= 3          => 'Partiellement nuageux',
            $c !== null && $c <= 48         => 'Brouillard',
            $c !== null && $c <= 67         => 'Pluie',
            $c !== null && $c <= 77         => 'Neige',
            $c !== null && $c <= 82         => 'Averses',
            $c !== null && $c <= 99         => 'Orage',
            default                         => 'Inconnu',
        };
    }

    private static function icon(?int $c): string {
        return match (true) {
            $c === 0               => '☀️',
            $c !== null && $c <= 3  => '⛅',
            $c !== null && $c <= 48 => '🌫️',
            $c !== null && $c <= 67 => '🌧️',
            $c !== null && $c <= 77 => '❄️',
            $c !== null && $c <= 82 => '🌦️',
            $c !== null && $c <= 99 => '⛈️',
            default                 => '🌡️',
        };
    }
}
