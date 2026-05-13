<?php
/**
 * Centralized real-time stats aggregator for the Admin Dashboard.
 * Uses the ACTUAL live DB column names:
 *   mission:     statut ('ouverte','en_cours','terminee'), no employer_id in live DB
 *   candidature: statut ('en_attente','acceptee','refusee'), mission_id, user_id
 */
class AdminStats {

    private PDO $db;

    public function __construct() {
        require_once __DIR__ . '/../Model/Database.php';
        $this->db = getConnection();
    }

    /** Full platform KPIs */
    public function getAll(): array {
        return [
            'users'        => $this->userStats(),
            'missions'     => $this->missionStats(),
            'candidatures' => $this->candidatureStats(),
            'events'       => $this->eventStats(),
            'resources'    => $this->resourceStats(),
            'activity'     => $this->recentActivity(),
            'charts'       => $this->chartData(),
        ];
    }

    // ── Users ────────────────────────────────────────────────────────────────
    private function userStats(): array {
        $row = $this->db->query("
            SELECT
                COUNT(*)                                                                       AS total,
                SUM(role = 'job_seeker')                                                       AS seekers,
                SUM(role = 'employer')                                                         AS employers,
                SUM(role = 'admin')                                                            AS admins,
                SUM(is_verified = 1)                                                           AS verified,
                SUM(MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())) AS new_this_month
            FROM users
        ")->fetch(PDO::FETCH_ASSOC);
        return $row ?? [];
    }

    // ── Missions ─────────────────────────────────────────────────────────────
    private function missionStats(): array {
        $row = $this->db->query("
            SELECT
                COUNT(*)                                                                         AS total,
                SUM(statut = 'ouverte')                                                          AS open,
                SUM(statut IN ('en_cours','terminee'))                                            AS closed,
                SUM(MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())) AS new_this_month
            FROM mission
        ")->fetch(PDO::FETCH_ASSOC);
        return $row ?? [];
    }

    // ── Candidatures ─────────────────────────────────────────────────────────
    private function candidatureStats(): array {
        $row = $this->db->query("
            SELECT
                COUNT(*)                                                                         AS total,
                SUM(statut = 'en_attente')                                                       AS pending,
                SUM(statut = 'acceptee')                                                         AS accepted,
                SUM(statut = 'refusee')                                                          AS rejected,
                SUM(MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())) AS new_this_month
            FROM candidature
        ")->fetch(PDO::FETCH_ASSOC);
        return $row ?? [];
    }

    // ── Events ───────────────────────────────────────────────────────────────
    private function eventStats(): array {
        $row = $this->db->query("
            SELECT
                COUNT(*)                 AS total,
                SUM(date >= CURDATE())   AS upcoming,
                SUM(date < CURDATE())    AS past
            FROM event
        ")->fetch(PDO::FETCH_ASSOC);
        return $row ?? [];
    }

    // ── Resources ────────────────────────────────────────────────────────────
    private function resourceStats(): array {
        $row = $this->db->query("
            SELECT
                COUNT(*)           AS total_items,
                COALESCE(SUM(quantity), 0)     AS total_stock,
                SUM(quantity <= 2) AS low_stock_count
            FROM resource
        ")->fetch(PDO::FETCH_ASSOC);
        return $row ?? [];
    }

    // ── Recent Activity Feed ─────────────────────────────────────────────────
    private function recentActivity(): array {
        $activity = [];

        // Last 3 registrations
        try {
            $stmt = $this->db->query("
                SELECT CONCAT(first_name,' ',last_name) AS label, role, created_at
                FROM users ORDER BY created_at DESC LIMIT 3
            ");
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $roleLabel = match($r['role']) {
                    'job_seeker' => 'Candidat',
                    'employer'   => 'Employeur',
                    default      => 'Admin'
                };
                $activity[] = [
                    'icon'  => 'fa-user-plus',
                    'color' => '#00ffcc',
                    'text'  => "Nouvel utilisateur : <strong>{$r['label']}</strong> ($roleLabel)",
                    'time'  => $r['created_at'],
                ];
            }
        } catch (\Throwable $e) {}

        // Last 3 candidatures (using real column names: mission_id, user_id, nom, prenom)
        try {
            $stmt = $this->db->query("
                SELECT c.created_at,
                       CONCAT(c.prenom, ' ', c.nom) AS seeker,
                       m.titre AS mission
                FROM candidature c
                JOIN mission m ON m.id = c.mission_id
                ORDER BY c.created_at DESC LIMIT 3
            ");
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $activity[] = [
                    'icon'  => 'fa-file-alt',
                    'color' => '#ffcc00',
                    'text'  => "<strong>{$r['seeker']}</strong> a postulé à <em>" . htmlspecialchars($r['mission']) . "</em>",
                    'time'  => $r['created_at'],
                ];
            }
        } catch (\Throwable $e) {}

        // Last 3 events
        try {
            $stmt = $this->db->query("
                SELECT title, date, location FROM event ORDER BY id DESC LIMIT 3
            ");
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $activity[] = [
                    'icon'  => 'fa-calendar-plus',
                    'color' => '#eb1616',
                    'text'  => "Événement : <strong>" . htmlspecialchars($r['title']) . "</strong> — " . htmlspecialchars($r['location']),
                    'time'  => $r['date'],
                ];
            }
        } catch (\Throwable $e) {}

        // Sort by time desc
        usort($activity, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));
        return array_slice($activity, 0, 8);
    }

    // ── Chart Data ───────────────────────────────────────────────────────────
    private function chartData(): array {
        // User growth (last 6 months)
        $growth = [];
        try {
            $stmt = $this->db->query("
                SELECT DATE_FORMAT(created_at,'%b %Y') AS month, COUNT(*) AS count
                FROM users
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY YEAR(created_at), MONTH(created_at)
                ORDER BY MIN(created_at)
            ");
            $growth = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {}

        // Candidature statut breakdown (real column: statut)
        $candStatus = [];
        try {
            $stmt = $this->db->query("
                SELECT statut AS status, COUNT(*) AS count
                FROM candidature GROUP BY statut
            ");
            $candStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Map French enum values to display labels
            foreach ($candStatus as &$row) {
                $row['status'] = match($row['status']) {
                    'en_attente' => 'En attente',
                    'acceptee'   => 'Acceptée',
                    'refusee'    => 'Refusée',
                    default      => $row['status']
                };
            }
        } catch (\Throwable $e) {}

        // Top missions by candidature count (no employer FK in live DB, use mission titre)
        $topMissions = [];
        try {
            $stmt = $this->db->query("
                SELECT m.titre AS mission, COUNT(c.id) AS count
                FROM mission m
                LEFT JOIN candidature c ON c.mission_id = m.id
                GROUP BY m.id ORDER BY count DESC LIMIT 5
            ");
            $topMissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {}

        return [
            'growth'       => $growth,
            'cand_status'  => $candStatus,
            'top_missions' => $topMissions,
        ];
    }
}
?>
