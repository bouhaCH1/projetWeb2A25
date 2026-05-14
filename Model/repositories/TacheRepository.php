<?php
class TacheRepository {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    public function statsByStatut(int $managerId): array {
        $s = $this->db->prepare("
            SELECT COALESCE(cts.statut,'en_attente') AS statut, COUNT(*) AS nb
            FROM taches t
            JOIN formations f ON f.id = t.formation_id
            JOIN participations p ON p.formation_id = f.id
            LEFT JOIN client_tache_statuts cts ON cts.tache_id = t.id AND cts.client_id = p.client_id
            WHERE f.manager_id = ?
            GROUP BY statut
        ");
        $s->execute([$managerId]);
        $out = ['en_attente'=>0,'en_cours'=>0,'termine'=>0];
        foreach ($s->fetchAll() as $r) $out[$r['statut']] = (int)$r['nb'];
        return $out;
    }

    public function getByFormation(int $fid): array {
        $s = $this->db->prepare("SELECT * FROM taches WHERE formation_id=? ORDER BY date_debut");
        $s->execute([$fid]); return $s->fetchAll();
    }

    public function getByClient(int $cid): array {
        $s = $this->db->prepare("
            SELECT t.*, f.titre AS formation_titre,
                   COALESCE(cts.statut,'en_attente') AS mon_statut
            FROM taches t
            JOIN formations f ON f.id = t.formation_id
            JOIN participations p ON p.formation_id = f.id AND p.client_id = ?
            LEFT JOIN client_tache_statuts cts ON cts.tache_id = t.id AND cts.client_id = ?
            ORDER BY t.date_debut
        ");
        $s->execute([$cid,$cid]); return $s->fetchAll();
    }

    public function getByFormationWithStatuts(int $fid): array {
        $taches = $this->getByFormation($fid);
        foreach ($taches as &$t) {
            $s = $this->db->prepare("
                SELECT c.id, c.nom, c.prenom, COALESCE(cts.statut,'en_attente') AS statut
                FROM participations p
                JOIN clients c ON c.id = p.client_id
                LEFT JOIN client_tache_statuts cts ON cts.tache_id = ? AND cts.client_id = p.client_id
                WHERE p.formation_id = ? ORDER BY c.nom
            ");
            $s->execute([$t['id'], $fid]);
            $t['statuts'] = $s->fetchAll();
        }
        return $taches;
    }

    public function getById(int $id): array|false {
        $s = $this->db->prepare("
            SELECT t.*, f.titre AS formation_titre FROM taches t
            JOIN formations f ON f.id=t.formation_id WHERE t.id=?
        ");
        $s->execute([$id]); return $s->fetch();
    }

    public function create(
        int $fid, string $titre, string $desc, int $duree,
        string $deb, string $fin,
        ?string $imagePath = null, ?string $videoUrl = null
    ): int {
        $s = $this->db->prepare("
            INSERT INTO taches (formation_id,titre,description,duree,date_debut,date_fin,image_path,video_url)
            VALUES(?,?,?,?,?,?,?,?)
        ");
        $s->execute([$fid,$titre,$desc,$duree,$deb,$fin,$imagePath,$videoUrl]);
        $tid = (int)$this->db->lastInsertId();

        $parts = $this->db->prepare("SELECT client_id FROM participations WHERE formation_id=?");
        $parts->execute([$fid]);
        $ins = $this->db->prepare("INSERT IGNORE INTO client_tache_statuts (tache_id,client_id,statut) VALUES(?,?,'en_attente')");
        foreach ($parts->fetchAll() as $p) { $ins->execute([$tid, $p['client_id']]); }
        return $tid;
    }

    public function update(
        int $id, string $titre, string $desc, int $duree,
        string $deb, string $fin,
        ?string $imagePath = null, ?string $videoUrl = null
    ): bool {
        $s = $this->db->prepare("
            UPDATE taches SET titre=?,description=?,duree=?,date_debut=?,date_fin=?,
            image_path=COALESCE(?,image_path),video_url=COALESCE(?,video_url) WHERE id=?
        ");
        return $s->execute([$titre,$desc,$duree,$deb,$fin,$imagePath,$videoUrl,$id]);
    }

    public function delete(int $id): bool {
        return $this->db->prepare("DELETE FROM taches WHERE id=?")->execute([$id]);
    }
}
