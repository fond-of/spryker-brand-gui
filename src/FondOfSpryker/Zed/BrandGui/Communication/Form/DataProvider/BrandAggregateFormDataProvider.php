<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider;

use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormDataProviderExpanderInterface;
use Generated\Shared\Transfer\BrandAggregateFormTransfer;

class BrandAggregateFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider
     */
    protected $brandFormDataProvider;

    /**
     * @var \FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormDataProviderExpanderInterface
     */
    protected $brandAggregateFormDataProviderExpander;

    /**
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider $brandFormDataProvider
     * @param \FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormDataProviderExpanderInterface $brandAggregateFormDataProviderExpander
     */
    public function __construct(
        BrandFormDataProvider $brandFormDataProvider,
        BrandAggregateFormDataProviderExpanderInterface $brandAggregateFormDataProviderExpander
    ) {
        $this->brandFormDataProvider = $brandFormDataProvider;
        $this->brandAggregateFormDataProviderExpander = $brandAggregateFormDataProviderExpander;
    }

    /**
     * @param int|null $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandAggregateFormTransfer
     */
    public function getData(?int $idBrand = null): BrandAggregateFormTransfer
    {
        $brandTransfer = $this->brandFormDataProvider->getData($idBrand);
        $brandAggregateFormTransfer = (new BrandAggregateFormTransfer())->setBrand($brandTransfer);
        $brandAggregateFormTransfer = $this->brandAggregateFormDataProviderExpander
            ->expandBrandAggregateFormData($brandAggregateFormTransfer);

        return $brandAggregateFormTransfer;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [];
    }
}
