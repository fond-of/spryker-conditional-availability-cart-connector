<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use DateTime;
use DateTimeInterface;
use FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceBridge implements ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
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

    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDateByDateTime(DateTime $dateTime): DateTimeInterface
    {
        return $this->service->generateEarliestDeliveryDateByDateTime($dateTime);
    }

    /**
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateLatestOrderDateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface
    {
        return $this->service->generateLatestOrderDateByDeliveryDate($deliveryDate);
    }
}
