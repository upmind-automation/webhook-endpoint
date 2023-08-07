<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Events;

use Upmind\Webhooks\Events\WebhookEvent;
use Upmind\Webhooks\Exceptions\InvalidPayloadException;

/**
 * Factory for creating webhook events from payload data.
 */
interface EventFactoryInterface
{
    /**
     * Get webhook events from the given payload data.
     *
     * @throws InvalidPayloadException
     *
     * @param array $data Webhook payload data
     *
     * @return WebhookEvent[]
     */
    public function getEvents(array $data): array;
}
