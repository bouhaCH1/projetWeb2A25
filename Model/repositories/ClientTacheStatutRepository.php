<?php
class ClientTacheStatutRepository {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    public function update(int $tacheId, int $clientId, string $statut): bool {
        $s = $this->db->prepare("
            INSERT INTO client_tache_statuts (tache_id,client_id,statut) VALUES(?,?,?)
            ON DUPLICATE KEY UPDATE statut=VALUES(statut)
        ");
        return $s->execute([$tacheId,$clientId,$statut]);
    }

    public function get(int $tacheId, int $clientId): string {
        $s = $this->db->prepare("SELECT statut FROM client_tache_statuts WHERE tache_id=? AND client_id=?");
        $s->execute([$tacheId,$clientId]);
        return $s->fetchColumn() ?: 'en_attente';
    }
}
