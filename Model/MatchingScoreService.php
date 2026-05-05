<?php

class MatchingScoreService {

    /**
     * Calcule un score de matching (0-100) entre une candidature et sa mission.
     *
     * @param array $candidature Données de la candidature
     * @param array $mission     Données de la mission
     * @param int   $previousApps Nombre de candidatures précédentes du même email pour la même catégorie
     * @return int Score entre 0 et 100
     */
    public static function calculate($candidature, $mission, $previousApps = 0) {
        $score = 0;

        // 1. Skills Match (40 points max)
        $score += self::scoreSkills($candidature['motivation'] ?? '', $mission['competences'] ?? '');

        // 2. Motivation Quality (30 points max)
        $score += self::scoreMotivationQuality($candidature['motivation'] ?? '');

        // 3. Relevance (20 points max)
        $score += self::scoreRelevance(
            $candidature['motivation'] ?? '',
            ($mission['titre'] ?? '') . ' ' . ($mission['description'] ?? '')
        );

        // 4. Experience / History (10 points max)
        $score += self::scoreExperience($previousApps);

        return min(100, max(0, (int) round($score)));
    }

    /**
     * Compare les compétences requises de la mission avec le texte de motivation.
     * 40 points max.
     */
    private static function scoreSkills($motivation, $missionSkills) {
        if (empty($missionSkills) || empty($motivation)) return 0;

        $motivation = strtolower($motivation);
        $skills = array_map('trim', explode(',', $missionSkills));
        $totalSkills = count($skills);
        if ($totalSkills === 0) return 0;

        $matched = 0;
        foreach ($skills as $skill) {
            $skill = strtolower(trim($skill));
            if (empty($skill)) continue;
            // Recherche exacte ou partielle (ex: "react" match "react.js")
            if (strpos($motivation, $skill) !== false) {
                $matched++;
            }
        }

        return ($matched / $totalSkills) * 40;
    }

    /**
     * Évalue la qualité de la motivation selon la longueur et la structure.
     * 30 points max.
     */
    private static function scoreMotivationQuality($motivation) {
        $length = mb_strlen(trim($motivation));

        // Score basé sur la longueur
        if ($length < 50)       $lengthScore = 5;
        elseif ($length < 100)  $lengthScore = 15;
        elseif ($length < 200)  $lengthScore = 22;
        elseif ($length < 350)  $lengthScore = 28;
        else                     $lengthScore = 30;

        // Bonus structure (ponctuation, phrases)
        $sentences = preg_match_all('/[.!?]+/', $motivation);
        $structureBonus = min(5, $sentences * 1.5);

        return min(30, $lengthScore + $structureBonus);
    }

    /**
     * Mesure la pertinence des mots-clés de la mission présents dans la motivation.
     * 20 points max.
     */
    private static function scoreRelevance($motivation, $missionText) {
        if (empty($motivation) || empty($missionText)) return 0;

        $motivation = strtolower(trim($motivation));
        $missionText = strtolower(trim($missionText));

        // Extraire les mots-clés significatifs (plus de 4 lettres) du texte de mission
        preg_match_all('/\b[a-zA-Zà-ÿ]{5,}\b/u', $missionText, $matches);
        $keywords = array_unique($matches[0] ?? []);
        $totalKeywords = count($keywords);
        if ($totalKeywords === 0) return 0;

        $matched = 0;
        foreach ($keywords as $word) {
            if (strpos($motivation, $word) !== false) {
                $matched++;
            }
        }

        // Score proportionnel, avec un minimum de points si au moins un mot match
        $ratio = $matched / $totalKeywords;
        $score = $ratio * 20;

        // Bonus si le titre de la mission est explicitement mentionné
        return min(20, $score);
    }

    /**
     * Score basé sur l'expérience passée (candidatures précédentes même catégorie).
     * 10 points max.
     */
    private static function scoreExperience($previousApplications) {
        if ($previousApplications >= 3) return 10;
        if ($previousApplications >= 1) return 5;
        return 0;
    }

    /**
     * Retourne un label stylisé selon le score.
     */
    public static function getScoreLabel($score) {
        if ($score >= 80) return ['Excellent Match', 'excellent'];
        if ($score >= 60) return ['Bon Match', 'good'];
        if ($score >= 40) return ['Match Moyen', 'average'];
        return ['Faible Match', 'low'];
    }

    /**
     * Retourne la classe CSS pour le cercle de progression.
     */
    public static function getScoreColor($score) {
        if ($score >= 80) return '#22c55e'; // green
        if ($score >= 60) return '#3b82f6'; // blue
        if ($score >= 40) return '#f59e0b'; // orange
        return '#ef4444'; // red
    }
}
