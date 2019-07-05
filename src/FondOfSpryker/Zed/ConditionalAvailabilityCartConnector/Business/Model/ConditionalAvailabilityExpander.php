<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use DateTime;
use FondOfSpryker\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use function array_unique;

class ConditionalAvailabilityExpander implements ConditionalAvailabilityExpanderInterface
{
    protected const MESSAGE_TYPE_ERROR = 'error';
    protected const DELIVERY_DATE_FORMAT = 'Y-m-d';

    protected const MESSAGE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE = 'conditional_availability_cart_connector.not_available_for_given_delivery_date';
    protected const MESSAGE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE = 'conditional_availability_cart_connector.not_available_for_earliest_delivery_date';
    protected const MESSAGE_NOT_AVAILABLE_FOR_GIVEN_QTY = 'conditional_availability_cart_connector.not_available_for_given_qty';

    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
     */
    protected $conditionalAvailabilityClient;

    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityService;

    /**
     * @var string[]
     */
    private $deliveryDates = [];

    /**
     * @var string[]
     */
    private $concreteDeliveryDates = [];

    /**
     * @param \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface $conditionalAvailabilityClient
     * @param \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface $conditionalAvailabilityClient,
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
    ) {
        $this->conditionalAvailabilityClient = $conditionalAvailabilityClient;
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $this->expandItem($itemTransfer);
        }

        $quoteTransfer->setDeliveryDates(array_unique($this->deliveryDates));
        $quoteTransfer->setConcreteDeliveryDates(array_unique($this->concreteDeliveryDates));

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItem(ItemTransfer $itemTransfer): ItemTransfer
    {
        if ($itemTransfer->getDeliveryDate() === ConditionalAvailabilityConstants::KEY_EARLIEST_DATE) {
            return $this->expandItemWithEarliestDeliveryDate($itemTransfer);
        }

        return $this->expandItemWithConcreteDeliveryDate($itemTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItemWithEarliestDeliveryDate(ItemTransfer $itemTransfer): ItemTransfer
    {
        $earliestDeliveryDate = $this->conditionalAvailabilityService->generateEarliestDeliveryDate();

        $resultSet = $this->conditionalAvailabilityClient->conditionalAvailabilitySkuSearch($itemTransfer->getSku(), [
            ConditionalAvailabilityConstants::PARAMETER_START_AT => $earliestDeliveryDate,
            ConditionalAvailabilityConstants::PARAMETER_WAREHOUSE => ConditionalAvailabilityConstants::DEFAULT_WAREHOUSE,
        ]);

        if ($resultSet->count() === 0) {
            return $itemTransfer->addValidationMessage($this->createNotAvailableForEarliestDeliveryDateMessage());
        }

        foreach ($resultSet->getResults() as $result) {
            $data = $result->getData();
            $dataQuantityInt = (int)$data['qty'];
            $dataStartAt = $data['startAt'];

            if ($dataQuantityInt < $itemTransfer->getQuantity()) {
                $itemTransfer->addValidationMessage($this->createNotAvailableForGivenQytMessage());
            }

            $itemTransfer->setDeliveryDate(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE);
            $startAtString = (new DateTime($dataStartAt))->format(static::DELIVERY_DATE_FORMAT);
            $itemTransfer->setConcreteDeliveryDate($startAtString);

            $this->deliveryDates[] = ConditionalAvailabilityConstants::KEY_EARLIEST_DATE;
            $this->concreteDeliveryDates[] = $startAtString;

            break;
        }

        return $itemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItemWithConcreteDeliveryDate(ItemTransfer $itemTransfer): ItemTransfer
    {
        $concreteDeliveryDate = new DateTime($itemTransfer->getDeliveryDate());

        $resultSet = $this->conditionalAvailabilityClient->conditionalAvailabilitySkuSearch($itemTransfer->getSku(), [
            ConditionalAvailabilityConstants::PARAMETER_START_AT => $concreteDeliveryDate,
            ConditionalAvailabilityConstants::PARAMETER_END_AT => $concreteDeliveryDate,
            ConditionalAvailabilityConstants::PARAMETER_WAREHOUSE => ConditionalAvailabilityConstants::DEFAULT_WAREHOUSE,
        ]);

        if ($resultSet->count() === 0) {
            return $itemTransfer->addValidationMessage($this->createNotAvailableForGivenDeliveryDateMessage());
        }

        foreach ($resultSet->getResults() as $result) {
            $data = $result->getData();
            $dataQuantityInt = (int)$data['qty'];
            $dataStartAt = $data['startAt'];

            $startAtDateTime = new DateTime($dataStartAt);
            if ($startAtDateTime < $concreteDeliveryDate) {
                continue;
            }

            if ($dataQuantityInt < $itemTransfer->getQuantity()) {
                $itemTransfer->addValidationMessage($this->createNotAvailableForGivenQytMessage());
            }

            $itemTransfer->setDeliveryDate($itemTransfer->getDeliveryDate());

            $startAtString = $startAtDateTime->format(static::DELIVERY_DATE_FORMAT);
            $itemTransfer->setConcreteDeliveryDate($startAtString);

            $this->deliveryDates[] = $startAtString;
            $this->concreteDeliveryDates[] = $startAtString;
        }

        return $itemTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createNotAvailableForGivenDeliveryDateMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::MESSAGE_NOT_AVAILABLE_FOR_GIVEN_DELIVERY_DATE);

        return $messageTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createNotAvailableForEarliestDeliveryDateMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::MESSAGE_NOT_AVAILABLE_FOR_EARLIEST_DELIVERY_DATE);

        return $messageTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createNotAvailableForGivenQytMessage(): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();

        $messageTransfer->setType(static::MESSAGE_TYPE_ERROR)
            ->setValue(static::MESSAGE_NOT_AVAILABLE_FOR_GIVEN_QTY);

        return $messageTransfer;
    }
}
