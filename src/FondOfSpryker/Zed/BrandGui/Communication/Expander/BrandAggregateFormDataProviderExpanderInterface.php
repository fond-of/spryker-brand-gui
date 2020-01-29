<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Expander;

use Generated\Shared\Transfer\BrandAggregateFormTransfer;

interface BrandAggregateFormDataProviderExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandAggregateFormTransfer $brandAggregateFormTransfer
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    public function expandBrandAggregateFormData(
        BrandAggregateFormTransfer $brandAggregateFormTransfer
    ): BrandAggregateFormTransfer;
}
