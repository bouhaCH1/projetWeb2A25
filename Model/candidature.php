<?php
class Candidature {
    private $conn;
    private $table = "candidature";

    public $mission_id;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $motivation;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (mission_id, nom, prenom, email, telephone, motivation)
                  VALUES (:mission_id, :nom, :prenom, :email, :telephone, :motivation)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mission_id', $this->mission_id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':motivation', $this->motivation);
        return $stmt->execute();
    }
}
?>
