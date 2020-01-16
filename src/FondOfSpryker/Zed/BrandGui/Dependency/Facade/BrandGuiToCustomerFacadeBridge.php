<?php

namespace FondOfSpryker\Zed\BrandGui\Dependency\Facade;

use Generated\Shared\Transfer\CustomerCollectionTransfer;

class BrandGuiToCustomerFacadeBridge implements BrandGuiToCustomerFacadeInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct($customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerCollectionTransfer
     */
    public function getCustomerCollection(): CustomerCollectionTransfer
    {
        return $this->customerFacade->getCustomerCollection(new CustomerCollectionTransfer());
    }
}
