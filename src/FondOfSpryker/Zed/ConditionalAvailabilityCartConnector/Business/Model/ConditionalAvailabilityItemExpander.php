<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;

class ConditionalAvailabilityItemExpander implements ConditionalAvailabilityItemExpanderInterface
{
    protected const GROUP_KEY_DELIMITER = '-';

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        foreach ($cartChangeTransfer->getItems() as $cartItem) {
            $cartItem->setGroupKey($this->buildGroupKey($cartItem));
        }

        return $cartChangeTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $cartItem
     *
     * @return string
     */
    protected function buildGroupKey(ItemTransfer $cartItem): string
    {
        $deliveryDate = $cartItem->getDeliveryTime();

        if (empty($deliveryDate)) {
            return $cartItem->getSku();
        }

        return $cartItem->getSku() . static::GROUP_KEY_DELIMITER . $deliveryDate;
    }
}
