<?php

declare(strict_types=1);

namespace Virustotal\Exception;

use Exception;
use Throwable;

class RestCallException extends Exception {

    /**
     * 
     * @param string $message
     * @param int $httpStatusCode
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(string $message, private readonly int $httpStatusCode, int $code = 0, ?Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * 
     * @return int
     */
    public function getHttpStatusCode(): int {
        return $this->httpStatusCode;
    }
}
