<?php
class CommentaireRepository {
    private PDO $db;
    public function __construct() { $this->db = getDB(); }

    public function getByTache(int $tacheId): array {
        $s = $this->db->prepare("
            SELECT c.*,
              CASE c.auteur_role
                WHEN 'manager' THEN (SELECT CONCAT(prenom,' ',nom) FROM managers WHERE id=c.auteur_id)
                WHEN 'client'  THEN (SELECT CONCAT(prenom,' ',nom) FROM clients  WHERE id=c.auteur_id)
              END AS auteur_nom
            FROM commentaires c
            WHERE c.tache_id = ?
            ORDER BY c.created_at ASC
        ");
        $s->execute([$tacheId]); return $s->fetchAll();
    }

    public function add(int $tacheId, int $auteurId, string $role, string $contenu): int {
        $s = $this->db->prepare("
            INSERT INTO commentaires (tache_id,auteur_id,auteur_role,contenu) VALUES(?,?,?,?)
        ");
        $s->execute([$tacheId,$auteurId,$role,$contenu]);
        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id, int $auteurId, string $role): bool {
        $s = $this->db->prepare("DELETE FROM commentaires WHERE id=? AND auteur_id=? AND auteur_role=?");
        return $s->execute([$id,$auteurId,$role]);
    }
}
