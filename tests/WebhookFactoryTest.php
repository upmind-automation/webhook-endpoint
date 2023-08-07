<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use Upmind\Webhooks\Auth\Secret;
use Upmind\Webhooks\Events\Version1EventFactory;
use Upmind\Webhooks\WebhookFactory;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class WebhookFactoryTest extends TestCase
{
    /** @test */
    public function can_create_from_valid_v1_string()
    {
        $secret = $this->getValidSecret();
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $secret);

        $factory = new WebhookFactory($secret);
        $webhook = $factory->fromString($payload, $signature);

        $this->assertInstanceOf(\Upmind\Webhooks\Events\WebhookEvent::class, $webhook->getEvents()[0]);

        $webhook->assertValidAuth();
    }

    /** @test */
    public function can_create_without_authentication()
    {
        $factory = new WebhookFactory();
        $webhook = $factory->fromString($this->getValidV1Payload());

        $this->assertInstanceOf(\Upmind\Webhooks\Events\WebhookEvent::class, $webhook->getEvents()[0]);
    }

    /** @test */
    public function invalid_payload_throws_exception()
    {
        $this->expectException(\Upmind\Webhooks\Exceptions\InvalidPayloadException::class);

        $factory = new WebhookFactory();
        $webhook = $factory->fromString('invalid payload');
    }

    /** @test */
    public function can_create_from_stdin()
    {
        $secret = $this->getValidSecret();
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $secret);

        $_SERVER['HTTP_X_WEBHOOK_SIGNATURE'] = $signature;
        $testFactory = new class($secret) extends WebhookFactory
        {
            protected const STDIN_STREAM_LOCATION = __DIR__ . '/../examples/example-v1-payload.json';
        };
        $webhook = $testFactory->create();

        $this->assertInstanceOf(\Upmind\Webhooks\Events\WebhookEvent::class, $webhook->getEvents()[0]);

        $webhook->assertValidAuth();
    }

    /** @test */
    public function can_create_from_valid_psr7_request()
    {
        $secret = $this->getValidSecret();
        $request = $this->getValidV1Psr7Request();

        $factory = new WebhookFactory($secret);
        $webhook = $factory->fromPsr7Request($request);

        $this->assertInstanceOf(\Upmind\Webhooks\Events\WebhookEvent::class, $webhook->getEvents()[0]);

        $webhook->assertValidAuth();
    }

    /** @test */
    public function unsupported_version_throws_exception()
    {
        $data = $this->payloadToData($this->getValidV1Payload());
        $data['version'] = 'V0';
        $payload = json_encode($data, JSON_PRETTY_PRINT);

        $this->expectException(\Upmind\Webhooks\Exceptions\UnsupportedVersionException::class);

        $factory = new WebhookFactory();
        $webhook = $factory->fromString($payload);

        $webhook->getEvents();
    }

    protected function getValidSecret(): Secret
    {
        return new Secret('This is a valid secret');
    }

    protected function getValidV1Psr7Request(): ServerRequestInterface
    {
        $payload = $this->getValidV1Payload();
        $signature = $this->calculateSignature($payload, $this->getValidSecret());

        $factory = new Psr17Factory();
        $request = $factory->createServerRequest('POST', 'https://example.com/webhook/endpoint')
            ->withHeader('X-Webhook-Signature', $signature)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($factory->createStream($payload));

        return $request;
    }

    public function tearDown(): void
    {
        unset($_SERVER['HTTP_X_WEBHOOK_SIGNATURE']);
    }
}
