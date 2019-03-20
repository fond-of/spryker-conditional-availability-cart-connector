<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Validator;

use Generated\Shared\Transfer\CartChangeTransfer;

interface ConditionalAvailabilityPingValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartPreCheckResponseTransfer
     */
    public function validateItems(CartChangeTransfer $cartChangeTransfer);
}
