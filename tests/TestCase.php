<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Upmind\Webhooks\Auth\Secret;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
abstract class TestCase extends BaseTestCase
{
    protected function markTestSucceeded()
    {
        $this->assertTrue(true);
    }

    protected function calculateSignature($payload, Secret $secret): string
    {
        return hash_hmac('sha256', $payload, $secret->toString());
    }

    protected function payloadToData(string $payload): array
    {
        return json_decode(trim($payload), true);
    }

    protected function getValidV1Payload(): string
    {
        return file_get_contents(__DIR__ . '/../examples/example-v1-payload.json');
    }
}
