<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use DateTime;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client\ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityExpander implements ConditionalAvailabilityExpanderInterface
{
    protected const MESSAGE_TYPE_ERROR = 'error';

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

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItem(ItemTransfer $itemTransfer): ItemTransfer
    {
        if ($itemTransfer->getDeliveryTime() === 'earliest-date') {
            return $this->expandItemWithEarliestDeliveryDate($itemTransfer);
        }

        return $this->expandItemWithConcreteDeliveryDate($itemTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandItemWithEarliestDeliveryDate(ItemTransfer $itemTransfer): ItemTransfer
    {
        $earliestDeliveryDate = $this->conditionalAvailabilityService->generateEarliestDeliveryDate();

        $resultSet = $this->conditionalAvailabilityClient->conditionalAvailabilitySkuSearch($itemTransfer->getSku(), [
            'start_at' => $earliestDeliveryDate,
            'warehouse' => 'EU',
        ]);

        if ($resultSet->count() === 0) {
            $itemTransfer->addMessage($this->createNotAvailableForEarliestDeliveryDateMessage());

            return $itemTransfer;
        }

        foreach ($resultSet->getResults() as $result) {
            $data = $result->getData();
            $dataQuantityInt = (int)$data['qty'];

            if ($dataQuantityInt < $itemTransfer->getQuantity()) {
                $itemTransfer->addMessage($this->createNotAvailableForGivenQytMessage());
            }
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
        $concreteDeliveryDate = new DateTime($itemTransfer->getDeliveryTime());

        $resultSet = $this->conditionalAvailabilityClient->conditionalAvailabilitySkuSearch($itemTransfer->getSku(), [
            'start_at' => $concreteDeliveryDate,
            'end_at' => $concreteDeliveryDate,
            'warehouse' => 'EU',
        ]);

        if ($resultSet->count() === 0) {
            $itemTransfer->addMessage($this->createNotAvailableForGivenDeliveryDateMessage());

            return $itemTransfer;
        }

        foreach ($resultSet->getResults() as $result) {
            $data = $result->getData();
            $dataQuantityInt = (int)$data['qty'];

            if ($dataQuantityInt < $itemTransfer->getQuantity()) {
                $itemTransfer->addMessage($this->createNotAvailableForGivenQytMessage());
            }
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
