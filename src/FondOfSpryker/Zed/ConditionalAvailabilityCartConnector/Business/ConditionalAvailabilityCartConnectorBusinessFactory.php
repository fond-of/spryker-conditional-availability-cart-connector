<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business;

use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
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
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner
     */
    public function createConditionalAvailabilityDeliveryDateCleaner(): ConditionalAvailabilityDeliveryDateCleanerInterface
    {
        return new ConditionalAvailabilityDeliveryDateCleaner();
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface
     */
    public function createConditionalAvailabilityItemExpander(): ConditionalAvailabilityItemExpanderInterface
    {
        return new ConditionalAvailabilityItemExpander(
            $this->getService()
        );
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected function getService(): ConditionalAvailabilityCartConnectorServiceInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected function getConditionalAvailabilityService(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
     */
    protected function getConditionalAvailabilityClient(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::CLIENT_CONDITIONAL_AVAILABILITY);
    }
}
