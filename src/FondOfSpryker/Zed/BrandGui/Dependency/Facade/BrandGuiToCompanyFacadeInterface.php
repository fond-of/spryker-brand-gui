<?php

namespace FondOfSpryker\Zed\BrandGui\Dependency\Facade;

use Generated\Shared\Transfer\CompanyCollectionTransfer;

interface BrandGuiToCompanyFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanyCollection(): CompanyCollectionTransfer;
}
