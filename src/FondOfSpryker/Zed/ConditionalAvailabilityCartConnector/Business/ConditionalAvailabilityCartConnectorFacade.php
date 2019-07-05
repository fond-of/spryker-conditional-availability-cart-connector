<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorBusinessFactory getFactory()
 */
class ConditionalAvailabilityCartConnectorFacade extends AbstractFacade implements ConditionalAvailabilityCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuoteAfterReloadItems(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()
            ->createConditionalAvailabilityExpander()
            ->expand($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandChangedCartItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        return $this->getFactory()
            ->createConditionalAvailabilityItemExpander()
            ->expandItems($cartChangeTransfer);
    }
}
