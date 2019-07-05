<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Communication;

use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorService;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig getConfig()
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface getFacade()
 */
class ConditionalAvailabilityCartConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    public function getService(): ConditionalAvailabilityCartConnectorServiceInterface
    {
        return new ConditionalAvailabilityCartConnectorService();
    }
}
