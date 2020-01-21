<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider;

use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandAggregateFormType;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeInterface;
use Generated\Shared\Transfer\BrandCustomerRelationTransfer;
use Generated\Shared\Transfer\BrandTransfer;

class BrandCustomerRelationFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @var \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface $brandFacade
     * @param \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        BrandGuiToBrandFacadeInterface $brandFacade,
        BrandGuiToCustomerFacadeInterface $customerFacade
    ) {
        $this->brandFacade = $brandFacade;
        $this->customerFacade = $customerFacade;
    }

    public function getData(?int $idBrand = null): BrandCustomerRelationTransfer
    {
        $brandCustomerRelationTransfer = new BrandCustomerRelationTransfer();

        if (!$idBrand) {
            return $brandCustomerRelationTransfer;
        }

        $brandTransfer = (new BrandTransfer())->setIdBrand($idBrand);
        $brandTransfer = $this->brandFacade
            ->findBrandById($brandTransfer);

        $brandCustomerRelationTransfer = $brandTransfer->getBrandCustomerRelation();

        if ($brandCustomerRelationTransfer === null) {
            return new BrandCustomerRelationTransfer();
        }

        return $brandCustomerRelationTransfer
            ->setIdBrand($brandTransfer->getIdBrand());
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $customerCollectionTransfer = $this->customerFacade->getCustomerCollection();
        $customerOptions = [];
        foreach ($customerCollectionTransfer->getCustomers() as $customerTransfer) {
            $customerOptions[] = $customerTransfer->getIdCustomer();
        }

        return [
            BrandAggregateFormType::OPTION_CUSTOMER_IDS => $customerOptions,
        ];
    }
}
