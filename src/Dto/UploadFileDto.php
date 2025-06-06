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

    /**
     * 
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self {
        return new self(
                type: $data['data']['type'] ?? '',
                id: $data['data']['id'] ?? '',
                selfLink: $data['data']['links']['self'] ?? ''
        );
    }

    /**
     * 
     * @return array
     */
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
}
