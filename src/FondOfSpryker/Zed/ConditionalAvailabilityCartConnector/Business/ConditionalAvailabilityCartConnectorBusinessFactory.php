<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business;

use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpander;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpander;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Spryker\Zed\Search\Business\SearchBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig getConfig()
 */
class ConditionalAvailabilityCartConnectorBusinessFactory extends SearchBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface
     */
    public function createConditionalAvailabilityExpander(): ConditionalAvailabilityExpanderInterface
    {
        return new ConditionalAvailabilityExpander(
            $this->getConditionalAvailabilityClient(),
            $this->getConditionalAvailabilityService()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface
     */
    public function createConditionalAvailabilityItemExpander(): ConditionalAvailabilityItemExpanderInterface
    {
        return new ConditionalAvailabilityItemExpander();
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected function getConditionalAvailabilityService(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::CONDITIONAL_AVAILABILITY_SERVICE);
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
     */
    protected function getConditionalAvailabilityClient(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::CONDITIONAL_AVAILABILITY_CLIENT);
    }
}
