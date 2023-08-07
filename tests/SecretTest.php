<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

use Upmind\Webhooks\Auth\Secret;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class SecretTest extends TestCase
{
    /** @test */
    public function test_can_get_raw_secret_string()
    {
        $secret = new Secret('secret');

        $this->assertEquals('secret', $secret->toString());
    }

    /** @test */
    public function test_can_instantiate_from_stringable()
    {
        $secret = new Secret(new Secret('secret'));

        $this->assertEquals('secret', $secret->toString());
    }
}
