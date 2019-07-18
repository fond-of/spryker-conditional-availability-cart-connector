<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\QuoteExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteWritePluginInterface;

/**
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig getConfig()
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Communication\ConditionalAvailabilityCartConnectorCommunicationFactory getFactory()
 */
class DeliveryDateCleanerOnEmptyCartQuoteAfterSavePlugin extends AbstractPlugin implements QuoteWritePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function execute(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->cleanDeliveryDateOnEmptyCart($quoteTransfer);
    }
}
