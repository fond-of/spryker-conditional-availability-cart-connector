<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use DateTime;
use FondOfSpryker\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityExpanderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\ConditionalAvailabilityExpander
     */
    protected $conditionalAvailabilityExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface
     */
    protected $conditionalAvailabilityFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model\CustomerReaderInterface
     */
    protected $customerReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $itemTransferMocks;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer
     */
    protected $conditionalAvailabilityTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\ConditionalAvailabilityTransfer[]
     */
    protected $conditionalAvailabilityTransferMocks;

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodCollectionTransfer
     */
    protected $conditionalAvailabilityPeriodCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer
     */
    protected $conditionalAvailabilityPeriodTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer[]
     */
    protected $conditionalAvailabilityPeriodTransferMocks;

    /**
     * @var string
     */
    protected $startAt;

    /**
     * @var string
     */
    protected $endAt;

    /**
     * @var \DateTime
     */
    protected $concreteDeliveryDate;

    /**
     * @var string
     */
    protected $customerReference;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityServiceInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReaderInterfaceMock = $this->getMockBuilder(CustomerReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMocks = [
            $this->itemTransferMock,
        ];

        $this->sku = 'sku';

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMock = $this->getMockBuilder(ConditionalAvailabilityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityTransferMocks = new ArrayObject([
            $this->sku => [
                $this->conditionalAvailabilityTransferMock,
            ],
        ]);

        $this->dateTime = new DateTime();

        $this->quantity = 1;

        $this->conditionalAvailabilityPeriodCollectionTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMock = $this->getMockBuilder(ConditionalAvailabilityPeriodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodTransferMocks = new ArrayObject([
            $this->conditionalAvailabilityPeriodTransferMock,
        ]);

        $this->startAt = (new DateTime())->format('Y-m-d');

        $this->endAt = (new DateTime())->modify('+1 day')->format('Y-m-d');

        $this->concreteDeliveryDate = new DateTime();

        $this->customerReference = 'customer-reference';

        $this->conditionalAvailabilityExpander = new ConditionalAvailabilityExpander(
            $this->conditionalAvailabilityFacadeInterfaceMock,
            $this->conditionalAvailabilityServiceInterfaceMock,
            $this->customerReaderInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($this->customerReference);

        $this->customerReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('getCustomerByCustomerReference')
            ->with($this->customerReference)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($this->concreteDeliveryDate->format('Y-m-d'));

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandEmpty(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([]));

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandNotAvailableForGivenQyt(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($this->concreteDeliveryDate->format('Y-m-d'));

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($this->concreteDeliveryDate->format('Y-m-d'));

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandNotAvailableForGivenDate(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($this->concreteDeliveryDate->format('Y-m-d'));

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandNotAvailableForGivenDeliveryDate(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn(new ArrayObject([]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($this->concreteDeliveryDate->format('Y-m-d'));

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateLatestOrderDateByDeliveryDate')
            ->willReturn($this->concreteDeliveryDate);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDate(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($this->dateTime);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDeliveryNotAvailableForGivenQyt(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($this->dateTime);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn($this->conditionalAvailabilityPeriodCollectionTransferMock);

        $this->conditionalAvailabilityPeriodCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriods')
            ->willReturn($this->conditionalAvailabilityPeriodTransferMocks);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getStartAt')
            ->willReturn($this->startAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getEndAt')
            ->willReturn($this->endAt);

        $this->conditionalAvailabilityPeriodTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn(0);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDeliveryNotAvailableForGivenDeliveryDate(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn(new ArrayObject([]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->willReturnSelf();

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($this->dateTime);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testExpandEarliestDeliveryNotAvailableForEarliestDeliveryDate(): void
    {
        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($this->itemTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($this->sku);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getHasAvailabilityRestrictions')
            ->willReturn(false);

        $this->conditionalAvailabilityFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findGroupedConditionalAvailabilities')
            ->willReturn($this->conditionalAvailabilityTransferMocks);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);

        $this->conditionalAvailabilityServiceInterfaceMock->expects(static::atLeastOnce())
            ->method('generateEarliestDeliveryDate')
            ->willReturn($this->dateTime);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getQuantity')
            ->willReturn($this->quantity);

        $this->conditionalAvailabilityTransferMock->expects(static::atLeastOnce())
            ->method('getConditionalAvailabilityPeriodCollection')
            ->willReturn(null);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('addValidationMessage')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDates')
            ->willReturnSelf();

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDates')
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->conditionalAvailabilityExpander->expand(
                $this->quoteTransferMock
            )
        );
    }
}
