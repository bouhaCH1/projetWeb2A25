<?php

require_once __DIR__ . '/Database.php';

class MissionCandidature {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnection();
    }

    public function getMissionCandidatures(): array {
        $sql = 'SELECT m.id AS mission_id, m.titre AS mission_titre, m.statut AS mission_statut, m.budget, '
            . "CONCAT(u_emp.first_name, ' ', u_emp.last_name) AS employeur_nom, u_emp.email AS employeur_email, "
            . "c.id AS candidature_id, CONCAT(u_cand.first_name, ' ', u_cand.last_name) AS candidat_nom, "
            . 'u_cand.email AS candidat_email, u_cand.phone AS candidat_telephone, '
            . 'c.statut AS candidature_statut, c.created_at AS candidature_date '
            . 'FROM mission m '
            . 'INNER JOIN users u_emp ON u_emp.id = m.employer_id '
            . 'INNER JOIN candidature c ON c.mission_id = m.id '
            . 'INNER JOIN users u_cand ON u_cand.id = c.user_id '
            . 'ORDER BY m.id DESC, c.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getMissionsWithOptionalCandidatures(): array {
        $sql = 'SELECT m.id AS mission_id, m.titre AS mission_titre, m.statut AS mission_statut, '
            . "CONCAT(u_emp.first_name, ' ', u_emp.last_name) AS employeur_nom, "
            . 'c.id AS candidature_id, '
            . "CONCAT(u_cand.first_name, ' ', u_cand.last_name) AS candidat_nom, "
            . 'c.statut AS candidature_statut '
            . 'FROM mission m '
            . 'INNER JOIN users u_emp ON u_emp.id = m.employer_id '
            . 'LEFT JOIN candidature c ON c.mission_id = m.id '
            . 'LEFT JOIN users u_cand ON u_cand.id = c.user_id '
            . 'ORDER BY m.id DESC, c.created_at DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
