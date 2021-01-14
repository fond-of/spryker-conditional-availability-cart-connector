<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use DateTimeInterface;

interface ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDate(): DateTimeInterface;
}
