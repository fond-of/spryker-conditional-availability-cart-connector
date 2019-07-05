<?php

namespace FondOfSpryker\Service\ConditionalAvailabilityCartConnector;

use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilder;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilder;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilder;
use FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

class ConditionalAvailabilityCartConnectorServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\ItemGroupKeyBuilderInterface
     */
    public function createItemGroupKeyBuilder(): ItemGroupKeyBuilderInterface
    {
        return new ItemGroupKeyBuilder($this->createGroupKeyBuilder());
    }

    /**
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\RestCartItemGroupKeyBuilderInterface
     */
    public function createRestCartItemGroupKeyBuilder(): RestCartItemGroupKeyBuilderInterface
    {
        return new RestCartItemGroupKeyBuilder($this->createGroupKeyBuilder());
    }

    /**
     * @return \FondOfSpryker\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilderInterface
     */
    protected function createGroupKeyBuilder(): GroupKeyBuilderInterface
    {
        return new GroupKeyBuilder();
    }
}
