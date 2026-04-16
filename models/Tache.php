<?php
require_once __DIR__ . '/../config/database.php';

class Tache {
    private PDO $db;
    public const STATUTS = ['en_attente'=>'En attente','en_cours'=>'En cours','termine'=>'Termine'];

    public function __construct() { $this->db = getDB(); }

    public function getByFormation(int $fid): array {
        $s = $this->db->prepare("SELECT * FROM taches WHERE formation_id=? ORDER BY date_debut");
        $s->execute([$fid]); return $s->fetchAll();
    }

    public function getByEtudiant(int $eid): array {
        $s = $this->db->prepare("
            SELECT t.*, f.titre AS formation_titre,
                   COALESCE(ets.statut,'en_attente') AS mon_statut
            FROM taches t
            JOIN formations f ON f.id = t.formation_id
            JOIN participations p ON p.formation_id = f.id AND p.etudiant_id = ?
            LEFT JOIN etudiant_tache_statuts ets ON ets.tache_id = t.id AND ets.etudiant_id = ?
            ORDER BY t.date_debut
        ");
        $s->execute([$eid,$eid]); return $s->fetchAll();
    }

    public function getByFormationWithStatuts(int $fid): array {
        $taches = $this->getByFormation($fid);
        foreach ($taches as &$t) {
            $s = $this->db->prepare("
                SELECT e.id, e.nom, e.prenom, COALESCE(ets.statut,'en_attente') AS statut
                FROM participations p
                JOIN etudiants e ON e.id = p.etudiant_id
                LEFT JOIN etudiant_tache_statuts ets ON ets.tache_id = ? AND ets.etudiant_id = p.etudiant_id
                WHERE p.formation_id = ? ORDER BY e.nom
            ");
            $s->execute([$t['id'], $fid]);
            $t['statuts'] = $s->fetchAll();
        }
        return $taches;
    }

    public function getById(int $id): array|false {
        $s = $this->db->prepare("SELECT t.*, f.titre AS formation_titre FROM taches t JOIN formations f ON f.id=t.formation_id WHERE t.id=?");
        $s->execute([$id]); return $s->fetch();
    }

    public function create(int $fid, string $titre, string $desc, int $duree, string $deb, string $fin): int {
        $s = $this->db->prepare("INSERT INTO taches (formation_id,titre,description,duree,date_debut,date_fin) VALUES(?,?,?,?,?,?)");
        $s->execute([$fid,$titre,$desc,$duree,$deb,$fin]);
        $tid = (int)$this->db->lastInsertId();
        $parts = $this->db->prepare("SELECT etudiant_id FROM participations WHERE formation_id=?");
        $parts->execute([$fid]);
        $ins = $this->db->prepare("INSERT IGNORE INTO etudiant_tache_statuts (tache_id,etudiant_id,statut) VALUES(?,?,'en_attente')");
        foreach ($parts->fetchAll() as $p) { $ins->execute([$tid, $p['etudiant_id']]); }
        return $tid;
    }

    public function update(int $id, string $titre, string $desc, int $duree, string $deb, string $fin): bool {
        $s = $this->db->prepare("UPDATE taches SET titre=?,description=?,duree=?,date_debut=?,date_fin=? WHERE id=?");
        return $s->execute([$titre,$desc,$duree,$deb,$fin,$id]);
    }

    public function delete(int $id): bool {
        return $this->db->prepare("DELETE FROM taches WHERE id=?")->execute([$id]);
    }
}
