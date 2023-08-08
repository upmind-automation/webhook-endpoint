<?php

declare(strict_types=1);

namespace Upmind\Webhooks\Events;

use JsonSerializable;

/**
 * Object encapsulating a webhook event.
 */
class WebhookEvent implements JsonSerializable
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $dateTime;

    /**
     * @var string
     */
    protected $categoryCode;

    /**
     * @var string
     */
    protected $hookCode;

    /**
     * @var string
     */
    protected $hookLogId;

    /**
     * @var string
     */
    protected $objectType;

    /**
     * @var array
     */
    protected $objectData;

    /**
     * @var array
     */
    protected $brandData;

    /**
     * @var string|null
     */
    protected $actorType;

    /**
     * @var array|null
     */
    protected $actorData;

    public function __construct(
        string $id,
        string $dateTime,
        string $categoryCode,
        string $hookCode,
        string $hookLogId,
        string $objectType,
        array $objectData,
        array $brandData,
        ?string $actorType,
        ?array $actorData
    ) {
        $this->id = $id;
        $this->dateTime = $dateTime;
        $this->categoryCode = $categoryCode;
        $this->hookCode = $hookCode;
        $this->hookLogId = $hookLogId;
        $this->objectType = $objectType;
        $this->objectData = $objectData;
        $this->brandData = $brandData;
        $this->actorType = $actorType;
        $this->actorData = $actorData;
    }

    /**
     * Get the unique webhook event ID (useful as an idempotency key).
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the webhook event date and time in ISO 8601 format, UTC.
     */
    public function getDateTime(): string
    {
        return $this->dateTime;
    }

    /**
     * Get the webhook event category code.
     */
    public function getCategoryCode(): string
    {
        return $this->categoryCode;
    }

    /**
     * Get the webhook event hook code.
     */
    public function getHookCode(): string
    {
        return $this->hookCode;
    }

    /**
     * Get the webhook event hook log ID.
     */
    public function getHookLogId(): string
    {
        return $this->hookLogId;
    }

    /**
     * Get the object type for this event.
     */
    public function getObjectType(): string
    {
        return $this->objectType;
    }

    /**
     * Get the object data for this event.
     */
    public function getObjectData(): array
    {
        return $this->objectData;
    }

    /**
     * Get the actor type, if known.
     */
    public function getActorType(): ?string
    {
        return $this->actorType;
    }

    /**
     * Get the actor data, if known.
     */
    public function getActorData(): ?array
    {
        return $this->actorData;
    }

    /**
     * Get the contextual brand data for this event.
     */
    public function getBrandData(): array
    {
        return $this->brandData;
    }

    /**
     * @return mixed[]
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'datetime' => $this->getDateTime(),
            'category_code' => $this->getCategoryCode(),
            'hook_code' => $this->getHookCode(),
            'hook_log_id' => $this->getHookLogId(),
            'object_type' => $this->getObjectType(),
            'object' => $this->getObjectData(),
            'actor_type' => $this->getActorType(),
            'actor' => $this->getActorData(),
            'brand' => $this->getBrandData(),
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
