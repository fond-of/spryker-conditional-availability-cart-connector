<?php

declare(strict_types=1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business;

use Generated\Shared\Transfer\QuoteTransfer;

interface ConditionalAvailabilityCartConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuoteAfterReloadItems(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
