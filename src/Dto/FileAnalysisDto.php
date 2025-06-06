<?php

declare(strict_types=1);

namespace Virustotal\Dto;

class FileAnalysisDto {

    public function __construct(
            public string $id,
            public string $type,
            public string $selfLink,
            public string $itemLink,
            public string $status,
            public int $date,
            public array $stats,
            public ?array $results,
            public string $sha256,
            public string $md5,
            public string $sha1,
            public int $size
    ) {
        
    }

    public static function fromArray(array $data): self {
        return new self(
                id: $data['data']['id'] ?? '',
                type: $data['data']['type'] ?? '',
                selfLink: $data['data']['links']['self'] ?? '',
                itemLink: $data['data']['links']['item'] ?? '',
                status: $data['data']['attributes']['status'] ?? '',
                date: $data['data']['attributes']['date'] ?? 0,
                stats: $data['data']['attributes']['stats'] ?? [],
                results: $data['data']['attributes']['results'] ?? null,
                sha256: $data['meta']['file_info']['sha256'] ?? '',
                md5: $data['meta']['file_info']['md5'] ?? '',
                sha1: $data['meta']['file_info']['sha1'] ?? '',
                size: $data['meta']['file_info']['size'] ?? 0
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'selfLink' => $this->selfLink,
            'itemLink' => $this->itemLink,
            'status' => $this->status,
            'date' => $this->date,
            'stats' => $this->stats,
            'results' => $this->results,
            'sha256' => $this->sha256,
            'md5' => $this->md5,
            'sha1' => $this->sha1,
            'size' => $this->size,
        ];
    }

    public function getId(): string {
        return $this->id;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getSelfLink(): string {
        return $this->selfLink;
    }

    public function getItemLink(): string {
        return $this->itemLink;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getDate(): int {
        return $this->date;
    }

    public function getStats(): array {
        return $this->stats;
    }

    public function getResults(): ?array {
        return $this->results;
    }

    public function getSha256(): string {
        return $this->sha256;
    }

    public function getMd5(): string {
        return $this->md5;
    }

    public function getSha1(): string {
        return $this->sha1;
    }

    public function getSize(): int {
        return $this->size;
    }

   
}
