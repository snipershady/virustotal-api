<?php

declare(strict_types=1);

namespace Virustotal\Dto;

class FileAnalysisDto {

    public function __construct(
            private readonly string $id,
            private readonly string $type,
            private readonly string $selfLink,
            private readonly string $itemLink,
            private readonly string $status,
            private readonly int $date,
            private readonly int $malicious,
            private readonly int $suspicious,
            private readonly int $undetected,
            private readonly int $harmless,
            private readonly int $timeout,
            private readonly int $confirmedTimeout,
            private readonly int $failure,
            private readonly int $typeUnsupported,
            private readonly ?array $results,
            private readonly string $sha256,
            private readonly string $md5,
            private readonly string $sha1,
            private readonly int $size
    ) {
        
    }

    /**
     * 
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self {
        $stats = $data['data']['attributes']['stats'] ?? [];

        return new self(
                id: $data['data']['id'] ?? '',
                type: $data['data']['type'] ?? '',
                selfLink: $data['data']['links']['self'] ?? '',
                itemLink: $data['data']['links']['item'] ?? '',
                status: $data['data']['attributes']['status'] ?? '',
                date: $data['data']['attributes']['date'] ?? 0,
                malicious: $stats['malicious'] ?? 0,
                suspicious: $stats['suspicious'] ?? 0,
                undetected: $stats['undetected'] ?? 0,
                harmless: $stats['harmless'] ?? 0,
                timeout: $stats['timeout'] ?? 0,
                confirmedTimeout: $stats['confirmed-timeout'] ?? 0,
                failure: $stats['failure'] ?? 0,
                typeUnsupported: $stats['type-unsupported'] ?? 0,
                results: $data['data']['attributes']['results'] ?? null,
                sha256: $data['meta']['file_info']['sha256'] ?? '',
                md5: $data['meta']['file_info']['md5'] ?? '',
                sha1: $data['meta']['file_info']['sha1'] ?? '',
                size: $data['meta']['file_info']['size'] ?? 0
        );
    }

    /**
     * 
     * @return array<string, array|int|string|null>
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'selfLink' => $this->selfLink,
            'itemLink' => $this->itemLink,
            'status' => $this->status,
            'date' => $this->date,
            'malicious' => $this->malicious,
            'suspicious' => $this->suspicious,
            'undetected' => $this->undetected,
            'harmless' => $this->harmless,
            'timeout' => $this->timeout,
            'confirmedTimeout' => $this->confirmedTimeout,
            'failure' => $this->failure,
            'typeUnsupported' => $this->typeUnsupported,
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

    public function getMalicious(): int {
        return $this->malicious;
    }

    public function getSuspicious(): int {
        return $this->suspicious;
    }

    public function getUndetected(): int {
        return $this->undetected;
    }

    public function getHarmless(): int {
        return $this->harmless;
    }

    public function getTimeout(): int {
        return $this->timeout;
    }

    public function getConfirmedTimeout(): int {
        return $this->confirmedTimeout;
    }

    public function getFailure(): int {
        return $this->failure;
    }

    public function getTypeUnsupported(): int {
        return $this->typeUnsupported;
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
