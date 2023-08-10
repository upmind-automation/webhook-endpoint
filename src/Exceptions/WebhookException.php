<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Exceptions;

use RuntimeException;

/**
 * Something went wrong while processing the incoming webhook.
 */
class WebhookException extends RuntimeException
{
    /**
     * @var int
     */
    protected $httpCode;

    /**
     * Get an appropriate HTTP response code for this exception.
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode ?? 500;
    }
}
