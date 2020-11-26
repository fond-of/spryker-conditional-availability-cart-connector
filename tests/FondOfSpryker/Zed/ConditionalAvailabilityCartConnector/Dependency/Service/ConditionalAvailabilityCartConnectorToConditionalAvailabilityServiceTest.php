<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service;

use Codeception\Test\Unit;
use DateTime;
use FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityService
     */
    protected $conditionalAvailabilityCartConnectorToConditionalAvailabilityService;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\DateTime
     */
    protected $dateTimeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityServiceInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dateTimeMock = $this->getMockBuilder(DateTime::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityService = new ConditionalAvailabilityCartConnectorToConditionalAvailabilityService(
            $this->conditionalAvailabilityServiceInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testGenerateEarliestDeliveryDate(): void
    {
        $this->conditionalAvailabilityServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($this->dateTimeMock);

        $this->assertInstanceOf(
            DateTime::class,
            $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityService->generateEarliestDeliveryDate()
        );
    }
}
