<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use DateTime;
use DateTimeInterface;

interface ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDate(): DateTimeInterface;

    /**
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateLatestOrderDateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface;
}
