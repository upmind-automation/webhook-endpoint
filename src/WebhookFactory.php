<?php

declare(strict_types=1);

namespace Upmind\Webhooks;

use Psr\Http\Message\ServerRequestInterface;
use Stringable;
use Throwable;
use Upmind\Webhooks\Auth\Secret;
use Upmind\Webhooks\Auth\SignatureAuth;
use Upmind\Webhooks\Events\EventFactoryInterface;
use Upmind\Webhooks\Events\Version1EventFactory;
use Upmind\Webhooks\Exceptions\InvalidPayloadException;
use Upmind\Webhooks\Exceptions\UnsupportedVersionException;

/**
 * Factory for creating Upmind webhook objects from incoming requests.
 */
class WebhookFactory
{
    /**
     * @var string
     */
    protected const STDIN_STREAM_LOCATION = 'php://input';

    /**
     * @var Secret
     */
    protected $secret;

    protected $eventFactoryVersionMap = [
        Webhook::VERSION_1 => Version1EventFactory::class,
    ];

    /**
     * @param Secret|string|Stringable|null $secret
     */
    public function __construct(
        #[\SensitiveParameter]
        $secret = null
    ) {
        $this->secret = new Secret($secret ?? '');
    }

    /**
     * Create a webhook instance from PHP STDIN and superglobals.
     */
    public function create(): Webhook
    {
        $headerKey = 'HTTP_' . str_replace('-', '_', strtoupper(SignatureAuth::HEADER));

        $payload = file_get_contents(static::STDIN_STREAM_LOCATION);
        $signature = $_SERVER[$headerKey] ?? null;

        return $this->fromString($payload, $signature);
    }

    /**
     * Create a webhook instance from a PSR-7 request object.
     *
     * @throws InvalidPayloadException
     */
    public function fromPsr7Request(ServerRequestInterface $request): Webhook
    {
        $payload = $request->getBody()->__toString();
        $signature = $request->getHeaderLine(SignatureAuth::HEADER) ?: null;

        return $this->fromString($payload, $signature);
    }

    /**
     * Create a webhook instance manually from a payload string and signature string.
     *
     * @throws InvalidPayloadException
     */
    public function fromString(string $payload, ?string $signature = null): Webhook
    {
        $auth = new SignatureAuth($this->secret, $payload, $signature ?? '');

        $data = json_decode($payload, true) ?? [];
        $version = $data['version'] ?? null;

        if (empty($version)) {
            throw new InvalidPayloadException('Webhook payload invalid or cannot be parsed');
        }

        if (!$this->supportsVersion($version)) {
            throw new UnsupportedVersionException('Unsupported webhook endpoint version');
        }

        $eventFactory = $this->getEventFactory($version);
        $events = $eventFactory->getEvents($data);

        return new Webhook($version, $events, $auth);
    }

    /**
     * Determine which webhook versions are supported by the factory.
     *
     * @param string|null $version
     *
     * @return bool
     */
    public function supportsVersion($version): bool
    {
        return array_key_exists($version, $this->eventFactoryVersionMap);
    }

    /**
     * Get an event factory for the given webhook version.
     *
     * @param string $version
     *
     * @return EventFactoryInterface
     */
    public function getEventFactory(string $version): EventFactoryInterface
    {
        $factoryClass = $this->eventFactoryVersionMap[$version];

        return new $factoryClass();
    }
}
