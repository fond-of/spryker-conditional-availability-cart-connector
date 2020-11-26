<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge
     */
    protected $conditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer
     */
    protected $conditionalAvailabilityCriteriaFilterTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCriteriaFilterTransferMock = $this->getMockBuilder(ConditionalAvailabilityCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge = new ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge(
            $this->conditionalAvailabilityFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedConditionalAvailabilities(): void
    {
        $this->conditionalAvailabilityFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->with($this->conditionalAvailabilityCriteriaFilterTransferMock)
            ->willReturn(new ArrayObject([]));

        $this->assertInstanceOf(
            ArrayObject::class,
            $this->conditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeBridge->findGroupedConditionalAvailabilities(
                $this->conditionalAvailabilityCriteriaFilterTransferMock
            )
        );
    }
}
