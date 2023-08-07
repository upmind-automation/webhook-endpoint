<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Auth;

use Upmind\Webhooks\Exceptions\InvalidAuthSignatureException;

/**
 * Class for authenticating incoming webhook signatures.
 */
class SignatureAuth implements AuthInterface
{
    /**
     * Upmind webhook signature header name.
     *
     * @var string
     */
    public const HEADER = 'X-Webhook-Signature';

    /**
     * @var Secret
     */
    protected $secret;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @param Secret $secret Endpoint secret
     * @param string $body Raw incoming request body
     * @param string $signature Incoming request signature
     */
    public function __construct(Secret $secret, string $body, string $signature)
    {
        $this->secret = $secret;
        $this->body = trim($body);
        $this->signature = $signature;
    }

    /**
     * {@inheritDoc}
     */
    public function getSecret(): Secret
    {
        return $this->secret;
    }

    /**
     * Determine whether the given incoming signature matches the hash generated
     * from the given body and secret.
     */
    public function authIsValid(): bool
    {
        $expected = hash_hmac('sha256', $this->body, $this->secret->toString());

        return hash_equals($expected, $this->signature);
    }

    /**
     * Assert that the incoming signature is valid.
     *
     * @throws InvalidAuthSignatureException
     *
     * @return void|no-return
     */
    public function assertValidAuth(): void
    {
        if (!$this->authIsValid()) {
            throw new InvalidAuthSignatureException('Invalid signature');
        }
    }
}
