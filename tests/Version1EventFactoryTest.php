<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Tests;

use Upmind\Webhooks\Events\Version1EventFactory;
use Upmind\Webhooks\Exceptions\InvalidPayloadException;

/**
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class Version1EventFactoryTest extends TestCase
{
    /** @test */
    public function can_create_from_valid_v1_payload_data()
    {
        $payload = $this->getValidV1Payload();
        $data = $this->payloadToData($payload);

        $factory = new Version1EventFactory();
        $events = $factory->getEvents($data);

        $this->assertInstanceOf(\Upmind\Webhooks\Events\WebhookEvent::class, $events[0]);
    }

    /** @test */
    public function invalid_payload_throws_exception()
    {
        $payload = $this->getValidV1Payload();
        $data = $this->payloadToData($payload);
        unset($data['object']);

        $this->expectException(\Upmind\Webhooks\Exceptions\InvalidPayloadException::class);

        try {
            $factory = new Version1EventFactory();
            $factory->getEvents($data);
        } catch (InvalidPayloadException $e) {
            $this->assertEquals(400, $e->getHttpCode());
            throw $e;
        }
    }
}
