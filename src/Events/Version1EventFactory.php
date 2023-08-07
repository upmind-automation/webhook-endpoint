<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Events;

use Throwable;
use Upmind\Webhooks\Exceptions\InvalidPayloadException;

/**
 * Factory for getting webhook events from a v1 webhook payload.
 */
class Version1EventFactory implements EventFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEvents(array $data): array
    {
        try {
            return [
                new WebhookEvent(
                    $data['webhook_event_id'],
                    $data['event_datetime'],
                    $data['hook_category'],
                    $data['hook_code'],
                    $data['hook_log_id'],
                    $data['object_type'],
                    $data['object'],
                    $data['brand'],
                    $data['actor_type'],
                    $data['actor']
                ),
            ];
        } catch (Throwable $e) {
            throw new InvalidPayloadException('Unable to parse events from payload', 400, $e);
        }
    }
}
