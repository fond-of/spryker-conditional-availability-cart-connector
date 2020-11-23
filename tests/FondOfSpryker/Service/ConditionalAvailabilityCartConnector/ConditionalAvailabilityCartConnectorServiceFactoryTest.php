<?php

namespace FondOfSpryker\Service\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface;

class ConditionalAvailabilityCartConnectorServiceFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceFactory
     */
    protected $conditionalAvailabilityCartConnectorServiceFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorServiceFactory = new ConditionalAvailabilityCartConnectorServiceFactory();
    }

    /**
     * @return void
     */
    public function testCreateItemGroupKeyBuilder(): void
    {
        $this->assertInstanceOf(
            ItemGroupKeyBuilderInterface::class,
            $this->conditionalAvailabilityCartConnectorServiceFactory->createItemGroupKeyBuilder()
        );
    }

    /**
     * @return void
     */
    public function testCreateRestCartItemGroupKeyBuilder(): void
    {
        $this->assertInstanceOf(
            RestCartItemGroupKeyBuilderInterface::class,
            $this->conditionalAvailabilityCartConnectorServiceFactory->createRestCartItemGroupKeyBuilder()
        );
    }
}
