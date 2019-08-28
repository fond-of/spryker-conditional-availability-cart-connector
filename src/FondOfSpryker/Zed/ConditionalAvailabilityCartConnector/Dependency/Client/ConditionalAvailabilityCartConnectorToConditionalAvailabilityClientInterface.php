<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client;

interface ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
{
    /**
     * @param string|null $searchString
     * @param string[] $requestParameters
     *
     * @return array
     */
    public function conditionalAvailabilitySkuSearch(?string $searchString, array $requestParameters = []): array;
}
