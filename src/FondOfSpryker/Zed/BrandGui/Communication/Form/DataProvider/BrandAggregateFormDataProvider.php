<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;

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
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider $brandFormDataProvider
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCustomerRelationFormDataProvider $brandCustomerRelationFormDataProvider
     */
    public function __construct(
        BrandFormDataProvider $brandFormDataProvider,
        BrandCustomerRelationFormDataProvider $brandCustomerRelationFormDataProvider
    ) {
        $this->brandFormDataProvider = $brandFormDataProvider;
        $this->brandCustomerRelationFormDataProvider = $brandCustomerRelationFormDataProvider;
    }

    public function getData(?int $idBrand = null): BrandAggregateFormTransfer
    {
        $assignedCustomerIds = [];
        $brandTransfer = $this->brandFormDataProvider->getData($idBrand);
        $brandCustomerRelation = $this->brandCustomerRelationFormDataProvider->getData($brandTransfer->getIdBrand());

        $brandCustomerRelationTransfer = $brandTransfer->getBrandCustomerRelation();
        if ($brandCustomerRelationTransfer && $brandCustomerRelationTransfer->getIdBrand()) {
            foreach ($brandTransfer->getBrandCustomerRelation()->getCustomerIds() as $customerId) {
                $assignedCustomerIds[] = $customerId;
            }
        }

        $aggregateFormTransfer = new BrandAggregateFormTransfer();
        $aggregateFormTransfer->setBrand($brandTransfer);
        $aggregateFormTransfer->setBrandCustomerRelation($brandCustomerRelation);
        $aggregateFormTransfer = $this->setAssignedCustomers($aggregateFormTransfer, $assignedCustomerIds);

        return $aggregateFormTransfer;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->brandCustomerRelationFormDataProvider->getOptions();
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
}
