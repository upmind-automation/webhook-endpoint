<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Exceptions;

/**
 * Thrown when webhook version unsupported, indicating the endpoint version
 * should be adjusted in Upmind.
 */
class UnsupportedVersionException extends InvalidPayloadException
{
    //
}
