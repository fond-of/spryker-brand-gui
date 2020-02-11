<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Expander;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Generated\Shared\Transfer\BrandCompanyRelationTransfer;
use Generated\Shared\Transfer\BrandCustomerRelationTransfer;
use Generated\Shared\Transfer\BrandProductAbstractRelationTransfer;
use Generated\Shared\Transfer\BrandTransfer;

class BrandAggregateFormDataProviderExpander implements BrandAggregateFormDataProviderExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandAggregateFormTransfer
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    public function expandBrandAggregateFormData(
        BrandAggregateFormTransfer $brandAggregateFormTransfer
    ): BrandAggregateFormTransfer {
        $brandAggregateFormTransfer->requireBrand();

        $brandTransfer = $brandAggregateFormTransfer->getBrand();

        return $brandAggregateFormTransfer
            ->setAssignedCustomerIds($this->getAssignedCustomerIds($brandTransfer))
            ->setAssignedCompanyIds($this->getAssignedCompanyIds($brandTransfer))
            ->setAssignedProductAbstractIds($this->getAssignedProductAbstractIds($brandTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return string
     */
    protected function getAssignedCustomerIds(BrandTransfer $brandTransfer): string
    {
        if (!$brandTransfer->getBrandCustomerRelation()) {
            $brandTransfer->setBrandCustomerRelation(new BrandCustomerRelationTransfer());
        }

        return implode(',', $brandTransfer->getBrandCustomerRelation()->getCustomerIds());
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return string
     */
    protected function getAssignedCompanyIds(BrandTransfer $brandTransfer): string
    {
        if (!$brandTransfer->getBrandCompanyRelation()) {
            $brandTransfer->setBrandCompanyRelation(new BrandCompanyRelationTransfer());
        }

        return implode(',', $brandTransfer->getBrandCompanyRelation()->getCompanyIds());
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return string
     */
    protected function getAssignedProductAbstractIds(BrandTransfer $brandTransfer): string
    {
        if (!$brandTransfer->getBrandProductAbstractRelation()) {
            $brandTransfer->setBrandProductAbstractRelation(new BrandProductAbstractRelationTransfer());
        }

        return implode(',', $brandTransfer->getBrandProductAbstractRelation()->getProductAbstractIds());
    }
}
