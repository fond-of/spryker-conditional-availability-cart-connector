<?php

namespace FondOfSpryker\Glue\ConditionalAvailabilityCartConnector;

use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorService;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class ConditionalAvailabilityCartConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    public function getService(): ConditionalAvailabilityCartConnectorServiceInterface
    {
        return new ConditionalAvailabilityCartConnectorService();
    }
}
