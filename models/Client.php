<?php

class Client {
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $password;
    private ?string $createdAt;

    public function __construct(
        ?int $id = null,
        string $nom = '',
        string $prenom = '',
        string $email = '',
        string $password = '',
        ?string $createdAt = null
    ) {
        $this->id        = $id;
        $this->nom       = $nom;
        $this->prenom    = $prenom;
        $this->email     = $email;
        $this->password  = $password;
        $this->createdAt = $createdAt;
    }

    public static function fromRow(array $r): self {
        return new self(
            isset($r['id']) ? (int)$r['id'] : null,
            $r['nom'] ?? '', $r['prenom'] ?? '',
            $r['email'] ?? '', $r['password'] ?? '',
            $r['created_at'] ?? null
        );
    }

    public function getId(): ?int            { return $this->id; }
    public function getNom(): string         { return $this->nom; }
    public function getPrenom(): string      { return $this->prenom; }
    public function getEmail(): string       { return $this->email; }
    public function getPassword(): string    { return $this->password; }
    public function getNomComplet(): string  { return $this->prenom . ' ' . $this->nom; }

    public function setNom(string $v): void      { $this->nom = $v; }
    public function setPrenom(string $v): void   { $this->prenom = $v; }
    public function setEmail(string $v): void    { $this->email = $v; }
    public function setPassword(string $v): void { $this->password = $v; }
}
