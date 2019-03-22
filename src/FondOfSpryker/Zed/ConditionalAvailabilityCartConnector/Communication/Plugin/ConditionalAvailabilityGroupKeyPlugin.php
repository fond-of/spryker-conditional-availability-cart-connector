<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Spryker\Zed\Cart\Dependency\ItemExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ConditionalAvailabilityGroupKeyPlugin extends AbstractPlugin implements ItemExpanderPluginInterface
{
    public const GROUP_KEY_DELIMITER = '-';

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer)
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
    protected function buildGroupKey(ItemTransfer $cartItem)
    {
        $deliveryTime = $cartItem->getDeliveryTime();

        if (empty($deliveryTime)) {
            return $cartItem->getSku();
        }

        return $cartItem->getSku() . static::GROUP_KEY_DELIMITER . $deliveryTime;
    }
}
