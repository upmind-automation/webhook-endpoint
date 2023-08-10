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
     * @var string
     */
    protected $objectId;

    /**
     * @var array
     */
    protected $objectData;

    /**
     * @var string
     */
    protected $brandId;

    /**
     * @var array
     */
    protected $brandData;

    /**
     * @var string|null
     */
    protected $actorType;

    /**
     * @var string|null
     */
    protected $actorId;

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
        string $objectId,
        array $objectData,
        string $brandId,
        array $brandData,
        ?string $actorType,
        ?string $actorId,
        ?array $actorData
    ) {
        $this->id = $id;
        $this->dateTime = $dateTime;
        $this->categoryCode = $categoryCode;
        $this->hookCode = $hookCode;
        $this->hookLogId = $hookLogId;
        $this->objectType = $objectType;
        $this->objectId = $objectId;
        $this->objectData = $objectData;
        $this->brandId = $brandId;
        $this->brandData = $brandData;
        $this->actorType = $actorType;
        $this->actorId = $actorId;
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
     * Get the object ID for this event.
     */
    public function getObjectId(): string
    {
        return $this->objectId;
    }

    /**
     * Get the object data for this event.
     */
    public function getObjectData(): array
    {
        return $this->objectData;
    }

    /**
     * Get the actor type, if applicable.
     */
    public function getActorType(): ?string
    {
        return $this->actorType;
    }

    /**
     * Get the actor ID, if applicable.
     */
    public function getActorId(): ?string
    {
        return $this->actorId;
    }

    /**
     * Get the actor data, if applicable.
     */
    public function getActorData(): ?array
    {
        return $this->actorData;
    }

    /**
     * Get the brand ID for this event.
     */
    public function getBrandId(): string
    {
        return $this->brandId;
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
            'object_id' => $this->getObjectId(),
            'object' => $this->getObjectData(),
            'actor_type' => $this->getActorType(),
            'actor_id' => $this->getActorId(),
            'actor' => $this->getActorData(),
            'brand_id' => $this->getBrandId(),
            'brand' => $this->getBrandData(),
        ];
    }

    /**
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
