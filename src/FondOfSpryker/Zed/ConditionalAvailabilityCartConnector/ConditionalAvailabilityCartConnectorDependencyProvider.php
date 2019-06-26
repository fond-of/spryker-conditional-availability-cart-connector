<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector;

use FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityService;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClient;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityService;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Search\SearchDependencyProvider;

class ConditionalAvailabilityCartConnectorDependencyProvider extends SearchDependencyProvider
{
    public const CONDITIONAL_AVAILABILITY_CLIENT = 'CONDITIONAL_AVAILABILITY_CLIENT';
    public const CONDITIONAL_AVAILABILITY_SERVICE = 'CONDITIONAL_AVAILABILITY_SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addConditionalAvailabilityClient($container);
        $container = $this->addConditionalAvailabilityService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConditionalAvailabilityClient(Container $container): Container
    {
        $container[static::CONDITIONAL_AVAILABILITY_CLIENT] = static function (Container $container) {
            return new ConditionalAvailabilityCartConnectorToConditionalAvailabilityClient(
                $container->getLocator()->conditionalAvailability()->client()
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
        $container[static::CONDITIONAL_AVAILABILITY_SERVICE] = static function () {
            return new ConditionalAvailabilityCartConnectorToConditionalAvailabilityService(
                new ConditionalAvailabilityService()
            );
        };

        return $container;
    }
}
