<?php

class Tache {
    public const STATUTS = ['en_attente'=>'En attente','en_cours'=>'En cours','termine'=>'Termine'];

    private ?int $id;
    private int $formationId;
    private string $titre;
    private string $description;
    private int $duree;
    private string $dateDebut;
    private string $dateFin;
    private ?string $imagePath;
    private ?string $videoUrl;
    private ?string $createdAt;

    public function __construct(
        ?int $id = null,
        int $formationId = 0,
        string $titre = '',
        string $description = '',
        int $duree = 0,
        string $dateDebut = '',
        string $dateFin = '',
        ?string $imagePath = null,
        ?string $videoUrl = null,
        ?string $createdAt = null
    ) {
        $this->id          = $id;
        $this->formationId = $formationId;
        $this->titre       = $titre;
        $this->description = $description;
        $this->duree       = $duree;
        $this->dateDebut   = $dateDebut;
        $this->dateFin     = $dateFin;
        $this->imagePath   = $imagePath;
        $this->videoUrl    = $videoUrl;
        $this->createdAt   = $createdAt;
    }

    public static function fromRow(array $r): self {
        return new self(
            isset($r['id']) ? (int)$r['id'] : null,
            (int)($r['formation_id'] ?? 0),
            $r['titre']        ?? '',
            $r['description']  ?? '',
            (int)($r['duree'] ?? 0),
            $r['date_debut']   ?? '',
            $r['date_fin']     ?? '',
            $r['image_path']   ?? null,
            $r['video_url']    ?? null,
            $r['created_at']   ?? null
        );
    }

    public function getId(): ?int               { return $this->id; }
    public function getFormationId(): int       { return $this->formationId; }
    public function getTitre(): string          { return $this->titre; }
    public function getDescription(): string    { return $this->description; }
    public function getDuree(): int             { return $this->duree; }
    public function getDateDebut(): string      { return $this->dateDebut; }
    public function getDateFin(): string        { return $this->dateFin; }
    public function getImagePath(): ?string     { return $this->imagePath; }
    public function getVideoUrl(): ?string      { return $this->videoUrl; }

    public function setId(int $v): void              { $this->id = $v; }
    public function setFormationId(int $v): void     { $this->formationId = $v; }
    public function setTitre(string $v): void        { $this->titre = $v; }
    public function setDescription(string $v): void  { $this->description = $v; }
    public function setDuree(int $v): void           { $this->duree = max(0, $v); }
    public function setDateDebut(string $v): void    { $this->dateDebut = $v; }
    public function setDateFin(string $v): void      { $this->dateFin = $v; }
    public function setImagePath(?string $v): void   { $this->imagePath = $v; }
    public function setVideoUrl(?string $v): void    { $this->videoUrl = $v; }
}
