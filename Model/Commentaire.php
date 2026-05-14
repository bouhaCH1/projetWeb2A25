<?php

class Commentaire {
    private ?int $id;
    private int $tacheId;
    private int $auteurId;
    private string $auteurRole;
    private string $contenu;
    private ?string $createdAt;
    private ?string $auteurNom;

    public function __construct(
        ?int $id = null,
        int $tacheId = 0,
        int $auteurId = 0,
        string $auteurRole = 'client',
        string $contenu = '',
        ?string $createdAt = null,
        ?string $auteurNom = null
    ) {
        $this->id         = $id;
        $this->tacheId    = $tacheId;
        $this->auteurId   = $auteurId;
        $this->auteurRole = $auteurRole;
        $this->contenu    = $contenu;
        $this->createdAt  = $createdAt;
        $this->auteurNom  = $auteurNom;
    }

    public static function fromRow(array $r): self {
        return new self(
            isset($r['id']) ? (int)$r['id'] : null,
            (int)($r['tache_id'] ?? 0),
            (int)($r['auteur_id'] ?? 0),
            $r['auteur_role'] ?? 'client',
            $r['contenu'] ?? '',
            $r['created_at'] ?? null,
            $r['auteur_nom'] ?? null
        );
    }

    public function getId(): ?int           { return $this->id; }
    public function getTacheId(): int       { return $this->tacheId; }
    public function getAuteurId(): int      { return $this->auteurId; }
    public function getAuteurRole(): string { return $this->auteurRole; }
    public function getContenu(): string    { return $this->contenu; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getAuteurNom(): ?string { return $this->auteurNom; }

    public function setContenu(string $v): void { $this->contenu = $v; }
}
