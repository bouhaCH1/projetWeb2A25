<?php
require_once __DIR__ . '/../config/database.php';

class Participant {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    public function getByFormation(int $fid): array {
        $s = $this->db->prepare("SELECT p.*, e.nom, e.prenom FROM participations p JOIN etudiants e ON e.id=p.etudiant_id WHERE p.formation_id=? ORDER BY e.nom");
        $s->execute([$fid]); return $s->fetchAll();
    }

    public function addById(int $fid, int $eid): bool {
        try {
            $s = $this->db->prepare("INSERT INTO participations (formation_id,etudiant_id) VALUES(?,?)");
            $ok = $s->execute([$fid,$eid]);
            if ($ok) $this->createStatutsForNewParticipant($fid, $eid);
            return $ok;
        } catch (PDOException $e) { return false; }
    }

    public function addManual(int $fid, string $nom, string $prenom): bool {
        $s = $this->db->prepare("INSERT INTO etudiants (nom,prenom) VALUES(?,?)");
        $s->execute([strtoupper($nom), ucfirst(strtolower($prenom))]);
        return $this->addById($fid, (int)$this->db->lastInsertId());
    }

    private function createStatutsForNewParticipant(int $fid, int $eid): void {
        $t = $this->db->prepare("SELECT id FROM taches WHERE formation_id=?");
        $t->execute([$fid]);
        $ins = $this->db->prepare("INSERT IGNORE INTO etudiant_tache_statuts (tache_id,etudiant_id,statut) VALUES(?,?,'en_attente')");
        foreach ($t->fetchAll() as $row) { $ins->execute([$row['id'], $eid]); }
    }

    public function remove(int $pid): bool {
        return $this->db->prepare("DELETE FROM participations WHERE id=?")->execute([$pid]);
    }

    public function isParticipant(int $fid, int $eid): bool {
        $s = $this->db->prepare("SELECT COUNT(*) FROM participations WHERE formation_id=? AND etudiant_id=?");
        $s->execute([$fid,$eid]); return (bool)$s->fetchColumn();
    }

    public function participate(int $fid, int $eid): bool { return $this->addById($fid,$eid); }

    public function leave(int $fid, int $eid): bool {
        $s = $this->db->prepare("DELETE FROM participations WHERE formation_id=? AND etudiant_id=?");
        return $s->execute([$fid,$eid]);
    }

    public function getAllEtudiants(): array {
        return $this->db->query("SELECT * FROM etudiants ORDER BY nom")->fetchAll();
    }
}
