<?php

declare(strict_types=1);

namespace Upmind\Webhooks;

use JsonSerializable;
use Upmind\Webhooks\Auth\AuthInterface;
use Upmind\Webhooks\Auth\Secret;
use Upmind\Webhooks\Events\WebhookEvent;

/**
 * Object encapsulating an incoming Upmind webhook.
 */
class Webhook implements AuthInterface, JsonSerializable
{
    /**
     * @var string
     */
    public const VERSION_1 = 'V1';

    /**
     * @var AuthInterface
     */
    protected $auth;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var WebhookEvent[]
     */
    protected $events;

    public function __construct(
        string $version,
        array $events,
        AuthInterface $auth
    ) {
        $this->auth = $auth;
        $this->version = $version;
        $this->events = $events;
    }

    /**
     * Get the webhook authentication strategy.
     */
    public function getAuth(): AuthInterface
    {
        return $this->auth;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecret(): Secret
    {
        return $this->auth->getSecret();
    }

    /**
     * {@inheritdoc}
     */
    public function authIsValid(): bool
    {
        return $this->auth->authIsValid();
    }

    /**
     * {@inheritdoc}
     */
    public function assertValidAuth(): void
    {
        $this->auth->assertValidAuth();
    }

    /**
     * Get the webhook event version.
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get an array of webhook events.
     *
     * @return WebhookEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return mixed[]
     */
    public function toArray()
    {
        return [
            'version' => $this->getVersion(),
            'events' => array_map(function (WebhookEvent $event) {
                return $event->toArray();
            }, $this->getEvents()),
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
