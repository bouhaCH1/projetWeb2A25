<?php

class Participation {
    private ?int $id;
    private int $formationId;
    private int $clientId;
    private ?string $dateInscription;

    public function __construct(
        ?int $id = null,
        int $formationId = 0,
        int $clientId = 0,
        ?string $dateInscription = null
    ) {
        $this->id              = $id;
        $this->formationId     = $formationId;
        $this->clientId        = $clientId;
        $this->dateInscription = $dateInscription;
    }

    public static function fromRow(array $r): self {
        return new self(
            isset($r['id']) ? (int)$r['id'] : null,
            (int)($r['formation_id'] ?? 0),
            (int)($r['client_id'] ?? 0),
            $r['date_inscription'] ?? null
        );
    }

    public function getId(): ?int              { return $this->id; }
    public function getFormationId(): int      { return $this->formationId; }
    public function getClientId(): int         { return $this->clientId; }
    public function getDateInscription(): ?string { return $this->dateInscription; }
}
