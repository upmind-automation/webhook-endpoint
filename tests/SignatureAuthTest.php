<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

use Upmind\Webhooks\Auth\Secret;
use Upmind\Webhooks\Auth\SignatureAuth;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class SignatureAuthTest extends TestCase
{
    /** @test */
    public function can_validate_signatures()
    {
        $secret = $this->getValidSecret();
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $secret);

        $signatureAuth = new SignatureAuth($secret, $payload, $signature);

        $this->assertTrue($signatureAuth->authIsValid());
    }

    /** @test */
    public function invalid_secrets_create_invalid_signatures()
    {
        $secret = $this->getValidSecret();
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $secret);

        $signatureAuth = new SignatureAuth(new Secret('invalid secret'), $payload, $signature);

        $this->assertFalse($signatureAuth->authIsValid());
    }

    /** @test */
    public function invalid_secret_auth_assertion_throws_exception()
    {
        $secret = $this->getValidSecret();
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $secret);

        $signatureAuth = new SignatureAuth(new Secret('invalid secret'), $payload, $signature);

        $this->expectException(\Upmind\Webhooks\Exceptions\InvalidAuthSignatureException::class);

        $signatureAuth->assertValidAuth();
    }

    /** @test */
    public function untrimmed_payload_generates_same_signature()
    {
        $secret = $this->getValidSecret();
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $secret);

        $untrimmedPayload = " \n" . $payload . "   \n";

        $signatureAuth = new SignatureAuth($secret, $untrimmedPayload, $signature);
        $signatureAuth->assertValidAuth();

        $this->markTestSucceeded();
    }

    protected function getValidSecret(): Secret
    {
        return new Secret('foo bar baz 123');
    }

    protected function getInvalidSecret(): Secret
    {
        return new Secret('invalid secret');
    }
}
