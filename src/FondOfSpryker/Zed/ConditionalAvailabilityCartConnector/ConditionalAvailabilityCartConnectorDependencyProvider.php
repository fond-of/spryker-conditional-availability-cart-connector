<?php

declare(strict_types = 1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector;

use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityService;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Search\SearchDependencyProvider;

class ConditionalAvailabilityCartConnectorDependencyProvider extends SearchDependencyProvider
{
    public const FACADE_CONDITIONAL_AVAILABILITY = 'FACADE_CONDITIONAL_AVAILABILITY';
    public const SERVICE_CONDITIONAL_AVAILABILITY = 'SERVICE_CONDITIONAL_AVAILABILITY';
    public const SERVICE = 'SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addConditionalAvailabilityFacade($container);
        $container = $this->addConditionalAvailabilityService($container);
        $container = $this->addService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityFacade(Container $container): Container
    {
        $container[static::FACADE_CONDITIONAL_AVAILABILITY] = static function (Container $container) {
            return new ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge(
                $container->getLocator()->conditionalAvailability()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityService(Container $container): Container
    {
        $container[static::SERVICE_CONDITIONAL_AVAILABILITY] = static function (Container $container) {
            return new ConditionalAvailabilityCartConnectorToConditionalAvailabilityService(
                $container->getLocator()->conditionalAvailability()->service()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addService(Container $container): Container
    {
        $container[static::SERVICE] = static function (Container $container) {
            return $container->getLocator()->conditionalAvailabilityCartConnector()->service();
        };

        return $container;
    }
}
