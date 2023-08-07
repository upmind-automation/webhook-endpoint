<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Auth;

use Upmind\Webhooks\Exceptions\InvalidAuthException;

/**
 * Interface for incoming webhook authentication.
 */
interface AuthInterface
{
    /**
     * Get the endpoint auth secret.
     */
    public function getSecret(): Secret;

    /**
     * Determine whether the webhook authentication is valid.
     */
    public function authIsValid(): bool;

    /**
     * Assert that the webhook authentication is valid, otherwise throws
     * InvalidSignatureException.
     *
     * @throws InvalidAuthException
     *
     * @return void|no-return
     */
    public function assertValidAuth(): void;
}
