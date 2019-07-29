<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client;

use Elastica\ResultSet;

interface ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
{
    /**
     * @param string|null $searchString
     * @param string[] $requestParameters
     *
     * @return \Elastica\ResultSet
     */
    public function conditionalAvailabilitySkuSearch(?string $searchString, array $requestParameters = []): ResultSet;
}
