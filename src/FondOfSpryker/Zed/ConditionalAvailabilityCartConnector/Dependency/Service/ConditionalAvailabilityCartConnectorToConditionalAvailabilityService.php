<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use DateTimeInterface;
use FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityService implements ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
{
    /**
     * @var \FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface
     */
    protected $service;

    /**
     * @param \FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface $service
     */
    public function __construct(ConditionalAvailabilityServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDate(): DateTimeInterface
    {
        return $this->service->generateEarliestDeliveryDate();
    }
}
