<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Persistence;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorPersistenceFactory getFactory()
 */
class ConditionalAvailabilityCartConnectorRepository extends AbstractRepository implements ConditionalAvailabilityCartConnectorRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return int|null
     */
    public function getIdCustomerByCustomerReference(string $customerReference): ?int
    {
        $spyCustomerQuery = $this->getFactory()->getCustomerQuery();

        /** @var int|null $idCustomer */
        $idCustomer = $spyCustomerQuery->clear()
            ->filterByCustomerReference($customerReference)
            ->select(SpyCustomerTableMap::COL_ID_CUSTOMER)
            ->findOne();

        return $idCustomer;
    }
}
