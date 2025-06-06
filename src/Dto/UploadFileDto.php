<?php

declare(strict_types=1);

namespace Virustotal\Dto;

class UploadFileDto {

    public function __construct(
            private readonly string $type,
            private readonly string $id,
            private readonly string $selfLink
    ) {
        
    }

    public static function fromArray(array $data): static {
        return new self(
                type: $data['data']['type'] ?? '',
                id: $data['data']['id'] ?? '',
                selfLink: $data['data']['links']['self'] ?? ''
        );
    }

    public function toArray(): array {
        return [
            'type' => $this->type,
            'id' => $this->id,
            'selfLink' => $this->selfLink,
        ];
    }

    public function getType(): string {
        return $this->type;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getSelfLink(): string {
        return $this->selfLink;
    }

    public function setType(string $type): static {
        $this->type = $type;
        return $this;
    }

    public function setId(string $id): static {
        $this->id = $id;
        return $this;
    }

    public function setSelfLink(string $selfLink): static {
        $this->selfLink = $selfLink;
        return $this;
    }
}
