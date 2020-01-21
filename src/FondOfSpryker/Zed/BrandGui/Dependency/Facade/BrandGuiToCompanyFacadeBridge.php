<?php

namespace FondOfSpryker\Zed\BrandGui\Dependency\Facade;

use FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;

class BrandGuiToCompanyFacadeBridge implements BrandGuiToCompanyFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface $companyFacade
     */
    public function __construct(CompanyFacadeInterface $companyFacade)
    {
        $this->companyFacade = $companyFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    public function getCompanyCollection(): CompanyCollectionTransfer
    {
        return $this->companyFacade->getCompanies();
    }
}
