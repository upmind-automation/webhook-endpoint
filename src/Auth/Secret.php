<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Auth;

use Stringable;

/**
 * Wrapper to encapsulate the endpoint secret string.
 */
class Secret
{
    /**
     * @var string
     */
    protected $secret;

    /**
     * @param string|Stringable $secret
     */
    public function __construct(
        #[\SensitiveParameter]
        $secret
    ) {
        $this->secret = strval($secret);
    }

    /**
     * Get the raw secret string.
     *
     * @return string
     */
    public function toString()
    {
        return $this->secret;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
