<?php

class Paginator {
    private int $total;
    private int $perPage;
    private int $currentPage;

    public function __construct(int $total, int $perPage = 5, int $currentPage = 1) {
        $this->total       = max(0, $total);
        $this->perPage     = max(1, $perPage);
        $this->currentPage = max(1, min($currentPage, max(1, (int)ceil($this->total / max(1,$perPage)))));
    }

    public function getOffset(): int      { return ($this->currentPage - 1) * $this->perPage; }
    public function getLimit(): int       { return $this->perPage; }
    public function getCurrentPage(): int { return $this->currentPage; }
    public function getTotalPages(): int  { return max(1, (int)ceil($this->total / $this->perPage)); }
    public function getTotal(): int       { return $this->total; }
    public function hasPrevious(): bool   { return $this->currentPage > 1; }
    public function hasNext(): bool       { return $this->currentPage < $this->getTotalPages(); }

    public function pages(): array {
        $tp = $this->getTotalPages();
        return range(1, $tp);
    }

    public function buildUrl(int $page, array $params = []): string {
        $params['page'] = $page;
        return 'index.php?' . http_build_query($params);
    }
}
