<?php
require_once __DIR__ . '/../config/database.php';

class Formation {
    private PDO $db;
    public const NIVEAUX = ['debutant'=>'Debutant','intermediaire'=>'Intermediaire','avance'=>'Avance'];

    public function __construct() { $this->db = getDB(); }

    public function getAll(): array {
        return $this->db->query("
            SELECT f.*, e.nom AS ens_nom, e.prenom AS ens_prenom,
                   COUNT(DISTINCT p.id) AS nb_participants,
                   COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            JOIN enseignants e ON e.id = f.enseignant_id
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            GROUP BY f.id ORDER BY f.date_debut DESC
        ")->fetchAll();
    }

    public function getByEnseignant(int $id): array {
        $s = $this->db->prepare("
            SELECT f.*, COUNT(DISTINCT p.id) AS nb_participants, COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            LEFT JOIN participations p ON p.formation_id = f.id
            LEFT JOIN taches t ON t.formation_id = f.id
            WHERE f.enseignant_id = ? GROUP BY f.id ORDER BY f.date_debut DESC
        ");
        $s->execute([$id]); return $s->fetchAll();
    }

    public function getByEtudiant(int $id): array {
        $s = $this->db->prepare("
            SELECT f.*, e.nom AS ens_nom, e.prenom AS ens_prenom, COUNT(DISTINCT t.id) AS nb_taches
            FROM formations f
            JOIN enseignants e ON e.id = f.enseignant_id
            JOIN participations p ON p.formation_id = f.id AND p.etudiant_id = ?
            LEFT JOIN taches t ON t.formation_id = f.id
            GROUP BY f.id ORDER BY f.date_debut DESC
        ");
        $s->execute([$id]); return $s->fetchAll();
    }

    public function getById(int $id): array|false {
        $s = $this->db->prepare("
            SELECT f.*, e.nom AS ens_nom, e.prenom AS ens_prenom
            FROM formations f JOIN enseignants e ON e.id = f.enseignant_id WHERE f.id = ?
        ");
        $s->execute([$id]); return $s->fetch();
    }

    public function create(string $titre, string $desc, string $lieu, string $niveau, int $cap, string $deb, string $fin, int $eid): int {
        $s = $this->db->prepare("INSERT INTO formations (titre,description,lieu,niveau,capacite_max,date_debut,date_fin,enseignant_id) VALUES(?,?,?,?,?,?,?,?)");
        $s->execute([$titre,$desc,$lieu,$niveau,$cap,$deb,$fin,$eid]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, string $titre, string $desc, string $lieu, string $niveau, int $cap, string $deb, string $fin): bool {
        $s = $this->db->prepare("UPDATE formations SET titre=?,description=?,lieu=?,niveau=?,capacite_max=?,date_debut=?,date_fin=? WHERE id=?");
        return $s->execute([$titre,$desc,$lieu,$niveau,$cap,$deb,$fin,$id]);
    }

    public function delete(int $id): bool {
        return $this->db->prepare("DELETE FROM formations WHERE id=?")->execute([$id]);
    }
}
