<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Exceptions;

/**
 * Thrown when webhook signature verification fails, indicating that the webhook
 * endpoint secret does not match.
 */
class InvalidAuthSignatureException extends InvalidAuthException
{
    //
}
