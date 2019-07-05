<?php

namespace FondOfSpryker\Glue\ConditionalAvailabilityCartConnector\Plugin\CompanyUserCartsRestApi;

use FondOfSpryker\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface;
use Generated\Shared\Transfer\RestCartItemTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory getFactory()
 */
class ConditionalAvailabilityGroupKeyPlugin extends AbstractPlugin implements RestCartItemExpanderPluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartItemTransfer
     * @api
     *
     */
    public function expand(RestCartItemTransfer $restCartItemTransfer): RestCartItemTransfer
    {
        $groupKey = $this->getFactory()->getService()->buildRestCartItemGroupKey($restCartItemTransfer);

        $restCartItemTransfer->setGroupKey($groupKey);

        return $restCartItemTransfer;
    }
}
