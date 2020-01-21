<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Generated\Shared\Transfer\BrandTransfer;

class BrandAggregateFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider
     */
    protected $brandFormDataProvider;

    /**
     * @var \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCustomerRelationFormDataProvider
     */
    protected $brandCustomerRelationFormDataProvider;

    /**
     * @var \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCompanyRelationFormDataProvider
     */
    protected $brandCompanyRelationFormDataProvider;

    /**
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider $brandFormDataProvider
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCustomerRelationFormDataProvider $brandCustomerRelationFormDataProvider
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCompanyRelationFormDataProvider $brandCompanyRelationFormDataProvider
     */
    public function __construct(
        BrandFormDataProvider $brandFormDataProvider,
        BrandCustomerRelationFormDataProvider $brandCustomerRelationFormDataProvider,
        BrandCompanyRelationFormDataProvider $brandCompanyRelationFormDataProvider
    ) {
        $this->brandFormDataProvider = $brandFormDataProvider;
        $this->brandCustomerRelationFormDataProvider = $brandCustomerRelationFormDataProvider;
        $this->brandCompanyRelationFormDataProvider = $brandCompanyRelationFormDataProvider;
    }

    /**
     * @param int|null $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    public function getData(?int $idBrand = null): BrandAggregateFormTransfer
    {
        $brandTransfer = $this->brandFormDataProvider->getData($idBrand);
        $brandAggregateFormTransfer = new BrandAggregateFormTransfer();
        $brandAggregateFormTransfer->setBrand($brandTransfer);
        $brandAggregateFormTransfer = $this->getCustomerData($brandTransfer, $brandAggregateFormTransfer);
        $brandAggregateFormTransfer = $this->getCompanyData($brandTransfer, $brandAggregateFormTransfer);

        return $brandAggregateFormTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     * @param \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandAggregateFormTransfer
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    protected function getCustomerData(
        BrandTransfer $brandTransfer,
        BrandAggregateFormTransfer $brandAggregateFormTransfer
    ): BrandAggregateFormTransfer {

        $assignedCustomerIds = [];
        $brandCustomerRelation = $this->brandCustomerRelationFormDataProvider->getData($brandTransfer->getIdBrand());
        $brandCustomerRelationTransfer = $brandTransfer->getBrandCustomerRelation();
        if ($brandCustomerRelationTransfer && $brandCustomerRelationTransfer->getIdBrand()) {
            foreach ($brandTransfer->getBrandCustomerRelation()->getCustomerIds() as $customerId) {
                $assignedCustomerIds[] = $customerId;
            }
        }

        $brandAggregateFormTransfer->setBrandCustomerRelation($brandCustomerRelation);
        $brandAggregateFormTransfer = $this->setAssignedCustomers($brandAggregateFormTransfer, $assignedCustomerIds);

        return $brandAggregateFormTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     * @param \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandAggregateFormTransfer
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    protected function getCompanyData(
        BrandTransfer $brandTransfer,
        BrandAggregateFormTransfer $brandAggregateFormTransfer
    ): BrandAggregateFormTransfer {

        $assignedCompanyIds = [];
        $brandCompanyRelation = $this->brandCompanyRelationFormDataProvider->getData($brandTransfer->getIdBrand());
        $brandCompanyRelationTransfer = $brandTransfer->getBrandCompanyRelation();
        if ($brandCompanyRelationTransfer && $brandCompanyRelationTransfer->getIdBrand()) {
            foreach ($brandTransfer->getBrandCompanyRelation()->getCompanyIds() as $companyId) {
                $assignedCompanyIds[] = $companyId;
            }
        }

        $brandAggregateFormTransfer->setBrandCompanyRelation($brandCompanyRelation);
        $brandAggregateFormTransfer = $this->setAssignedCompanies($brandAggregateFormTransfer, $assignedCompanyIds);

        return $brandAggregateFormTransfer;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->brandCustomerRelationFormDataProvider->getOptions() +
            $this->brandCompanyRelationFormDataProvider->getOptions();
    }

    /**
     * @param \Generated\Shared\Transfer\BrandAggregateFormTransfer $aggregateFormTransfer
     * @param array $assignedCustomerIds
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    protected function setAssignedCustomers(
        BrandAggregateFormTransfer $aggregateFormTransfer,
        array $assignedCustomerIds
    ): BrandAggregateFormTransfer {
        $aggregateFormTransfer->setAssignedCustomerIds(implode(',', $assignedCustomerIds));

        return $aggregateFormTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandAggregateFormTransfer $aggregateFormTransfer
     * @param array $assignedCompanyIds
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    protected function setAssignedCompanies(
        BrandAggregateFormTransfer $aggregateFormTransfer,
        array $assignedCompanyIds
    ): BrandAggregateFormTransfer {
        $aggregateFormTransfer->setAssignedCompanyIds(implode(',', $assignedCompanyIds));

        return $aggregateFormTransfer;
    }
}
