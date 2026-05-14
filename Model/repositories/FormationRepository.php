<?php
class FormationRepository {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    /**
     * @return array{sql:string,params:array<int,mixed>}
     */
    private function buildSearchClause(array $filters): array {
        $where  = [];
        $params = [];

        $q = trim((string)($filters['q'] ?? ''));
        if ($q !== '') {
            $where[]  = '(f.titre LIKE ? OR f.description LIKE ? OR f.lieu LIKE ?)';
            $like     = '%' . $q . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        $niveau = trim((string)($filters['niveau'] ?? ''));
        if ($niveau !== '' && array_key_exists($niveau, Formation::NIVEAUX)) {
            $where[]  = 'f.niveau = ?';
            $params[] = $niveau;
        }

        $lieu = trim((string)($filters['lieu'] ?? ''));
        if ($lieu !== '') {
            $where[]  = 'f.lieu LIKE ?';
            $params[] = '%' . $lieu . '%';
        }

        return [
            'sql'    => $where ? (' AND ' . implode(' AND ', $where)) : '',
            'params' => $params,
        ];
    }

    public function countByManager(int $id): int {
        $s = $this->db->prepare("SELECT COUNT(*) FROM formations WHERE manager_id = ?");
        $s->execute([$id]); return (int)$s->fetchColumn();
    }

    public function countByManagerFiltered(int $id, array $filters = []): int {
        $built = $this->buildSearchClause($filters);
        $sql   = "SELECT COUNT(*) FROM formations f WHERE f.manager_id = ?" . $built['sql'];
        $s     = $this->db->prepare($sql);
        $s->execute(array_merge([$id], $built['params']));
        return (int)$s->fetchColumn();
    }

    public function getByManagerPaged(int $id, int $limit, int $offset): array {
        $s = $this->db->prepare("
            SELECT f.*, COUNT(DISTINCT p.id) AS nb_participants, COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            WHERE f.manager_id = ? GROUP BY f.id ORDER BY f.date_debut DESC
            LIMIT $limit OFFSET $offset
        ");
        $s->execute([$id]); return $s->fetchAll();
    }

    public function getByManagerPagedFiltered(int $id, int $limit, int $offset, array $filters = []): array {
        $built = $this->buildSearchClause($filters);
        $sql = "
            SELECT f.*, COUNT(DISTINCT p.id) AS nb_participants, COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            WHERE f.manager_id = ?" . $built['sql'] . "
            GROUP BY f.id ORDER BY f.date_debut DESC
            LIMIT $limit OFFSET $offset
        ";
        $s = $this->db->prepare($sql);
        $s->execute(array_merge([$id], $built['params']));
        return $s->fetchAll();
    }

    public function statsByNiveau(int $managerId): array {
        $s = $this->db->prepare("SELECT niveau, COUNT(*) as nb FROM formations WHERE manager_id=? GROUP BY niveau");
        $s->execute([$managerId]);
        $out = ['debutant'=>0,'intermediaire'=>0,'avance'=>0];
        foreach ($s->fetchAll() as $r) $out[$r['niveau']] = (int)$r['nb'];
        return $out;
    }

    public function getAll(): array {
        return $this->db->query("
            SELECT f.*, m.nom AS mgr_nom, m.prenom AS mgr_prenom,
                   COUNT(DISTINCT p.id) AS nb_participants,
                   COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            JOIN managers m ON m.id = f.manager_id
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            GROUP BY f.id ORDER BY f.date_debut DESC
        ")->fetchAll();
    }

    public function getAllFiltered(array $filters = []): array {
        $built = $this->buildSearchClause($filters);
        $sql = "
            SELECT f.*, m.nom AS mgr_nom, m.prenom AS mgr_prenom,
                   COUNT(DISTINCT p.id) AS nb_participants,
                   COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            JOIN managers m ON m.id = f.manager_id
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            WHERE 1=1 " . $built['sql'] . "
            GROUP BY f.id ORDER BY f.date_debut DESC
        ";
        $s = $this->db->prepare($sql);
        $s->execute($built['params']);
        return $s->fetchAll();
    }

    public function getByManager(int $id): array {
        $s = $this->db->prepare("
            SELECT f.*, COUNT(DISTINCT p.id) AS nb_participants, COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            WHERE f.manager_id = ? GROUP BY f.id ORDER BY f.date_debut DESC
        ");
        $s->execute([$id]); return $s->fetchAll();
    }

    public function getByClient(int $id): array {
        $s = $this->db->prepare("
            SELECT f.*, m.nom AS mgr_nom, m.prenom AS mgr_prenom, COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            JOIN managers m ON m.id = f.manager_id
            JOIN participations p ON p.formation_id = f.id AND p.client_id = ?
            LEFT JOIN taches t ON t.formation_id = f.id
            GROUP BY f.id ORDER BY f.date_debut DESC
        ");
        $s->execute([$id]); return $s->fetchAll();
    }

    public function getById(int $id): array|false {
        $s = $this->db->prepare("
            SELECT f.*, m.nom AS mgr_nom, m.prenom AS mgr_prenom, m.email AS mgr_email
            FROM formations f JOIN managers m ON m.id = f.manager_id WHERE f.id = ?
        ");
        $s->execute([$id]); return $s->fetch();
    }

    public function create(
        string $titre, string $desc, string $lieu, string $niveau,
        int $cap, string $deb, string $fin, int $mid,
        ?string $imagePath = null, ?string $videoUrl = null
    ): int {
        $s = $this->db->prepare("
            INSERT INTO formations
            (titre,description,lieu,niveau,capacite_max,date_debut,date_fin,manager_id,image_path,video_url)
            VALUES(?,?,?,?,?,?,?,?,?,?)
        ");
        $s->execute([$titre,$desc,$lieu,$niveau,$cap,$deb,$fin,$mid,$imagePath,$videoUrl]);
        return (int)$this->db->lastInsertId();
    }

    public function update(
        int $id, string $titre, string $desc, string $lieu, string $niveau,
        int $cap, string $deb, string $fin,
        ?string $imagePath = null, ?string $videoUrl = null
    ): bool {
        $s = $this->db->prepare("
            UPDATE formations SET titre=?,description=?,lieu=?,niveau=?,capacite_max=?,
            date_debut=?,date_fin=?,image_path=COALESCE(?,image_path),video_url=COALESCE(?,video_url) WHERE id=?
        ");
        return $s->execute([$titre,$desc,$lieu,$niveau,$cap,$deb,$fin,$imagePath,$videoUrl,$id]);
    }

    public function delete(int $id): bool {
        return $this->db->prepare("DELETE FROM formations WHERE id=?")->execute([$id]);
    }
}
