<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Client;

use Elastica\ResultSet;
use FondOfSpryker\Client\ConditionalAvailability\ConditionalAvailabilityClientInterface;

class ConditionalAvailabilityCartConnectorToConditionalAvailabilityClient implements ConditionalAvailabilityCartConnectorToConditionalAvailabilityClientInterface
{
    /**
     * @var \FondOfSpryker\Client\ConditionalAvailability\ConditionalAvailabilityClientInterface
     */
    protected $client;

    /**
     * @param \FondOfSpryker\Client\ConditionalAvailability\ConditionalAvailabilityClientInterface $client
     *
     */
    public function __construct(ConditionalAvailabilityClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $searchString
     * @param string[] $requestParameters
     *
     * @return \Elastica\ResultSet
     */
    public function conditionalAvailabilitySkuSearch(?string $searchString, array $requestParameters = []): ResultSet
    {
        return $this->client->conditionalAvailabilitySkuSearch($searchString, $requestParameters);
    }
}