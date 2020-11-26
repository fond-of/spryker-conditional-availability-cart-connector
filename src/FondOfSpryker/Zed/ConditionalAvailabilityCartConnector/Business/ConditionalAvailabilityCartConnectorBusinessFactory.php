<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business;

use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleaner;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDate;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpander;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpander;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityItemExpanderInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\CustomerReader;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\CustomerReaderInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig getConfig()
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface getRepository()
 */
class ConditionalAvailabilityCartConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpanderInterface
     */
    public function createConditionalAvailabilityExpander(): ConditionalAvailabilityExpanderInterface
    {
        return new ConditionalAvailabilityExpander(
            $this->getConditionalAvailabilityFacade(),
            $this->getConditionalAvailabilityService(),
            $this->createCustomerReader()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->getRepository(),
            $this->getCustomerFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityDeliveryDateCleanerInterface
     */
    public function createConditionalAvailabilityDeliveryDateCleaner(): ConditionalAvailabilityDeliveryDateCleanerInterface
    {
        return new ConditionalAvailabilityDeliveryDateCleaner();
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityEnsureEarliestDateInterface
     */
    public function createConditionalAvailabilityEnsureEarliestDate(): ConditionalAvailabilityEnsureEarliestDateInterface
    {
        return new ConditionalAvailabilityEnsureEarliestDate();
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
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    protected function getService(): ConditionalAvailabilityCartConnectorServiceInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE);
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected function getConditionalAvailabilityService(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::SERVICE_CONDITIONAL_AVAILABILITY
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface
     */
    protected function getConditionalAvailabilityFacade(): ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
     */
    protected function getCustomerFacade(): ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::FACADE_CUSTOMER
        );
    }
}
