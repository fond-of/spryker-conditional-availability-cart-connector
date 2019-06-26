<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business;

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
    public function expandQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFactory()
            ->createConditionalAvailabilityExpander()
            ->expand($quoteTransfer);
    }
}
