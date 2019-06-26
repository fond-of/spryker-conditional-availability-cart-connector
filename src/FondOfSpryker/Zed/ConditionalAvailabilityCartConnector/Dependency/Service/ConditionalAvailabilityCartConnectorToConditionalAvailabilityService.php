<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use DateTime;
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
     * @return \DateTime
     */
    public function generateEarliestDeliveryDate(): DateTime
    {
        return $this->service->generateEarliestDeliveryDate();
    }
}
