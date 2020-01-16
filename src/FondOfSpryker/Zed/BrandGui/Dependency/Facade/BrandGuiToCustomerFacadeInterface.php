<?php

namespace FondOfSpryker\Zed\BrandGui\Dependency\Facade;

use Generated\Shared\Transfer\CustomerCollectionTransfer;

interface BrandGuiToCustomerFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\CustomerCollectionTransfer
     */
    public function getCustomerCollection(): CustomerCollectionTransfer;
}
