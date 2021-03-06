<?php

declare (strict_types = 1);

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use FondOfSpryker\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityEnsureEarliestDate implements ConditionalAvailabilityEnsureEarliestDateInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function ensureEarliestDate(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->ensureEarliestDeliveryDate($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function ensureEarliestDeliveryDate(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        foreach ($quoteTransfer->getDeliveryDates() as $deliveryDate) {
            if ($deliveryDate === ConditionalAvailabilityConstants::KEY_EARLIEST_DATE) {
                return $quoteTransfer;
            }
        }

        $deliveryDates = $quoteTransfer->getDeliveryDates();
        $deliveryDates[] = ConditionalAvailabilityConstants::KEY_EARLIEST_DATE;

        $quoteTransfer->setDeliveryDates($deliveryDates);

        return $quoteTransfer;
    }
}
