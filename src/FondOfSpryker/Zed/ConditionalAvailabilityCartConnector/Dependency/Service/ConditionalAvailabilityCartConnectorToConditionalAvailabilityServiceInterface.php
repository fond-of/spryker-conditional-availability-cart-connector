<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use DateTime;

interface ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
{
    /**
     * @return \DateTime
     */
    public function generateEarliestDeliveryDate(): DateTime;
}
