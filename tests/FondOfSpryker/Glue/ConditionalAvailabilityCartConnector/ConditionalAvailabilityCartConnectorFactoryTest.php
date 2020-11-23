<?php

namespace FondOfSpryker\Glue\ConditionalAvailabilityCartConnector;

use Codeception\Test\Unit;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;

class ConditionalAvailabilityCartConnectorFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory
     */
    protected $conditionalAvailabilityCartConnectorFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorFactory = new ConditionalAvailabilityCartConnectorFactory();
    }

    /**
     * @return void
     */
    public function testGetService(): void
    {
        $this->assertInstanceOf(
            ConditionalAvailabilityCartConnectorServiceInterface::class,
            $this->conditionalAvailabilityCartConnectorFactory->getService()
        );
    }
}
