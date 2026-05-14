<?php
class ParticipantRepository {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    public function getByFormation(int $fid): array {
        $s = $this->db->prepare("
            SELECT p.*, c.nom, c.prenom, c.email
            FROM participations p JOIN clients c ON c.id=p.client_id
            WHERE p.formation_id=? ORDER BY c.nom
        ");
        $s->execute([$fid]); return $s->fetchAll();
    }

    public function addById(int $fid, int $cid): bool {
        try {
            $s = $this->db->prepare("INSERT INTO participations (formation_id,client_id) VALUES(?,?)");
            $ok = $s->execute([$fid,$cid]);
            if ($ok) $this->createStatutsForNewClient($fid, $cid);
            return $ok;
        } catch (PDOException) { return false; }
    }

    public function addManual(int $fid, string $nom, string $prenom, string $email, string $password): bool {
        $s = $this->db->prepare("INSERT INTO clients (nom,prenom,email,password) VALUES(?,?,?,?)");
        $s->execute([strtoupper($nom), ucfirst(strtolower($prenom)), $email, password_hash($password, PASSWORD_DEFAULT)]);
        return $this->addById($fid, (int)$this->db->lastInsertId());
    }

    private function createStatutsForNewClient(int $fid, int $cid): void {
        $t = $this->db->prepare("SELECT id FROM taches WHERE formation_id=?");
        $t->execute([$fid]);
        $ins = $this->db->prepare("INSERT IGNORE INTO client_tache_statuts (tache_id,client_id,statut) VALUES(?,?,'en_attente')");
        foreach ($t->fetchAll() as $row) { $ins->execute([$row['id'], $cid]); }
    }

    public function remove(int $pid): bool {
        return $this->db->prepare("DELETE FROM participations WHERE id=?")->execute([$pid]);
    }

    public function isParticipant(int $fid, int $cid): bool {
        $s = $this->db->prepare("SELECT COUNT(*) FROM participations WHERE formation_id=? AND client_id=?");
        $s->execute([$fid,$cid]); return (bool)$s->fetchColumn();
    }

    public function participate(int $fid, int $cid): bool { return $this->addById($fid,$cid); }

    public function leave(int $fid, int $cid): bool {
        $s = $this->db->prepare("DELETE FROM participations WHERE formation_id=? AND client_id=?");
        return $s->execute([$fid,$cid]);
    }

    public function getAllClients(): array {
        return $this->db->query("SELECT * FROM clients ORDER BY nom")->fetchAll();
    }
}
