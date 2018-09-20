<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\ConditionalAvailabilityGroupKeyPlugin;

class ConditionalAvailabilityGroupKeyPluginTest extends Unit
{
    const SKU = 'sku';
    const DELIVERY_TIME = '27.10.2018';
    const GROUP_KEY_DELIMITER = '-';
    const RESULTING_GROUP_KEY = self::SKU . self::GROUP_KEY_DELIMITER . self::DELIVERY_TIME;

    /**
     * @return void
     */
    public function testExpandItemMustSetGroupKeyToSkuOfGivenProductWhenNoGroupKeyIsSet()
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setSku(self::SKU);
        $itemTransfer->setDeliveryTime(self::DELIVERY_TIME);

        $changeTransfer = new CartChangeTransfer();
        $changeTransfer->addItem($itemTransfer);

        $plugin = new ConditionalAvailabilityGroupKeyPlugin();
        $plugin->expandItems($changeTransfer);

        $this->assertSame(self::RESULTING_GROUP_KEY, $changeTransfer->getItems()[0]->getGroupKey());
    }

    /**
     * @return void
     */
    public function testExpandItemMustSetGroupKeyToSkuOfGivenProductWhenNoDeliveryDateIsSet()
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setSku(self::SKU);
        $itemTransfer->setDeliveryTime("");

        $changeTransfer = new CartChangeTransfer();
        $changeTransfer->addItem($itemTransfer);

        $plugin = new ConditionalAvailabilityGroupKeyPlugin();
        $plugin->expandItems($changeTransfer);

        $this->assertSame(self::SKU, $changeTransfer->getItems()[0]->getGroupKey());
    }

    /**
     * @return void
     */
    public function testExpandItemMustNotChangeGroupKeyWhenGroupKeyIsSet()
    {
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setSku(self::SKU);
        $itemTransfer->setGroupKey(self::DELIVERY_TIME);
        $itemTransfer->setDeliveryTime(self::DELIVERY_TIME);

        $changeTransfer = new CartChangeTransfer();
        $changeTransfer->addItem($itemTransfer);

        $plugin = new ConditionalAvailabilityGroupKeyPlugin();
        $plugin->expandItems($changeTransfer);

        $this->assertSame(self::RESULTING_GROUP_KEY, $changeTransfer->getItems()[0]->getGroupKey());
    }
}
