<?php

class Formation {
    public const NIVEAUX = ['debutant'=>'Debutant','intermediaire'=>'Intermediaire','avance'=>'Avance'];

    private ?int $id;
    private string $titre;
    private string $description;
    private string $lieu;
    private string $niveau;
    private int $capaciteMax;
    private string $dateDebut;
    private string $dateFin;
    private int $managerId;
    private ?string $imagePath;
    private ?string $videoUrl;
    private ?string $createdAt;

    public function __construct(
        ?int $id = null,
        string $titre = '',
        string $description = '',
        string $lieu = '',
        string $niveau = 'debutant',
        int $capaciteMax = 0,
        string $dateDebut = '',
        string $dateFin = '',
        int $managerId = 0,
        ?string $imagePath = null,
        ?string $videoUrl = null,
        ?string $createdAt = null
    ) {
        $this->id           = $id;
        $this->titre        = $titre;
        $this->description  = $description;
        $this->lieu         = $lieu;
        $this->niveau       = $niveau;
        $this->capaciteMax  = $capaciteMax;
        $this->dateDebut    = $dateDebut;
        $this->dateFin      = $dateFin;
        $this->managerId    = $managerId;
        $this->imagePath    = $imagePath;
        $this->videoUrl     = $videoUrl;
        $this->createdAt    = $createdAt;
    }

    public static function fromRow(array $r): self {
        return new self(
            isset($r['id']) ? (int)$r['id'] : null,
            $r['titre']        ?? '',
            $r['description']  ?? '',
            $r['lieu']         ?? '',
            $r['niveau']       ?? 'debutant',
            (int)($r['capacite_max'] ?? 0),
            $r['date_debut']   ?? '',
            $r['date_fin']     ?? '',
            (int)($r['manager_id'] ?? 0),
            $r['image_path']   ?? null,
            $r['video_url']    ?? null,
            $r['created_at']   ?? null
        );
    }

    public function getId(): ?int             { return $this->id; }
    public function getTitre(): string        { return $this->titre; }
    public function getDescription(): string  { return $this->description; }
    public function getLieu(): string         { return $this->lieu; }
    public function getNiveau(): string       { return $this->niveau; }
    public function getNiveauLabel(): string  { return self::NIVEAUX[$this->niveau] ?? $this->niveau; }
    public function getCapaciteMax(): int     { return $this->capaciteMax; }
    public function getDateDebut(): string    { return $this->dateDebut; }
    public function getDateFin(): string      { return $this->dateFin; }
    public function getManagerId(): int       { return $this->managerId; }
    public function getImagePath(): ?string   { return $this->imagePath; }
    public function getVideoUrl(): ?string    { return $this->videoUrl; }
    public function getCreatedAt(): ?string   { return $this->createdAt; }

    public function setId(int $v): void           { $this->id = $v; }
    public function setTitre(string $v): void     { $this->titre = $v; }
    public function setDescription(string $v): void { $this->description = $v; }
    public function setLieu(string $v): void      { $this->lieu = $v; }
    public function setNiveau(string $v): void    { $this->niveau = array_key_exists($v, self::NIVEAUX) ? $v : 'debutant'; }
    public function setCapaciteMax(int $v): void  { $this->capaciteMax = max(0, $v); }
    public function setDateDebut(string $v): void { $this->dateDebut = $v; }
    public function setDateFin(string $v): void   { $this->dateFin = $v; }
    public function setManagerId(int $v): void    { $this->managerId = $v; }
    public function setImagePath(?string $v): void { $this->imagePath = $v; }
    public function setVideoUrl(?string $v): void  { $this->videoUrl = $v; }
}
