<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class WebhookExceptionHttpCodeTest extends TestCase
{
    /** @test */
    public function exception_http_codes_are_valid_error_codes()
    {
        $exceptionFiles = glob(__DIR__ . '/../src/Exceptions/*.php');

        foreach ($exceptionFiles as $file) {
            $className = 'Upmind\\Webhooks\\Exceptions\\' . basename($file, '.php');
            $reflection = new \ReflectionClass($className);
            $exception = $reflection->newInstanceWithoutConstructor();

            $this->assertGreaterThanOrEqual(400, $exception->getHttpCode(), $className . ' has invalid http code');
            $this->assertLessThanOrEqual(599, $exception->getHttpCode(), $className . ' has invalid http code');
        }
    }
}
