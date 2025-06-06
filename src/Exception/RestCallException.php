<?php

declare(strict_types=1);

namespace Virustotal\Exception;

class RestCallException extends Exception {

    /**
     * 
     * @param string $message
     * @param int $httpStatusCode
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(string $message, private readonly int $httpStatusCode = 0, int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getHttpStatusCode(): int {
        return $this->httpStatusCode;
    }
}
