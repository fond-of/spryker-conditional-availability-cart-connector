<?php

namespace FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerReader implements CustomerReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface $repository
     * @param \FondOfSpryker\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorRepositoryInterface $repository,
        ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade
    ) {
        $this->repository = $repository;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerByCustomerReference(string $customerReference): CustomerTransfer
    {
        $idCustomer = $this->repository->getIdCustomerByCustomerReference($customerReference);
        $customerTransfer = (new CustomerTransfer())->setIdCustomer($idCustomer);

        return $this->customerFacade->getCustomer($customerTransfer);
    }
}
