<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider;

use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandAggregateFormType;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCompanyFacadeInterface;
use Generated\Shared\Transfer\BrandCompanyRelationTransfer;
use Generated\Shared\Transfer\BrandTransfer;

class BrandCompanyRelationFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @var \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface $brandFacade
     * @param \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCompanyFacadeInterface $companyFacade
     */
    public function __construct(
        BrandGuiToBrandFacadeInterface $brandFacade,
        BrandGuiToCompanyFacadeInterface $companyFacade
    ) {
        $this->brandFacade = $brandFacade;
        $this->companyFacade = $companyFacade;
    }

    /**
     * @param int|null $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandCompanyRelationTransfer
     */
    public function getData(?int $idBrand = null): BrandCompanyRelationTransfer
    {
        $brandCompanyRelationTransfer = new BrandCompanyRelationTransfer();

        if (!$idBrand) {
            return $brandCompanyRelationTransfer;
        }

        $brandTransfer = (new BrandTransfer())->setIdBrand($idBrand);
        $brandTransfer = $this->brandFacade
            ->findBrandById($brandTransfer);

        $brandCompanyRelationTransfer = $brandTransfer->getBrandCompanyRelation();

        if ($brandCompanyRelationTransfer === null) {
            return new BrandCompanyRelationTransfer();
        }

        return $brandCompanyRelationTransfer
            ->setIdBrand($brandTransfer->getIdBrand());
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $companyCollectionTransfer = $this->companyFacade->getCompanyCollection();
        $companyOptions = [];

        foreach ($companyCollectionTransfer->getCompanies() as $companyTransfer) {
            $companyOptions[] = $companyTransfer->getIdCompany();
        }

        return [
            BrandAggregateFormType::OPTION_COMPANY_IDS => $companyOptions,
        ];
    }
}
