<?php
require_once __DIR__ . '/../config/database.php';

class EtudiantTacheStatut {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    public function update(int $tacheId, int $etudiantId, string $statut): bool {
        $s = $this->db->prepare("
            INSERT INTO etudiant_tache_statuts (tache_id,etudiant_id,statut) VALUES(?,?,?)
            ON DUPLICATE KEY UPDATE statut=VALUES(statut)
        ");
        return $s->execute([$tacheId,$etudiantId,$statut]);
    }

    public function get(int $tacheId, int $etudiantId): string {
        $s = $this->db->prepare("SELECT statut FROM etudiant_tache_statuts WHERE tache_id=? AND etudiant_id=?");
        $s->execute([$tacheId,$etudiantId]);
        return $s->fetchColumn() ?: 'en_attente';
    }
}
