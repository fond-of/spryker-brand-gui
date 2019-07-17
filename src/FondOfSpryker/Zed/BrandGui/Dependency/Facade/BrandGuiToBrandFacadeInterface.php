<?php

namespace FondOfSpryker\Zed\BrandGui\Dependency\Facade;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandResponseTransfer;
use Generated\Shared\Transfer\BrandTransfer;

interface BrandGuiToBrandFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandResponseTransfer
     */
    public function addBrand(BrandTransfer $brandTransfer): BrandResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandResponseTransfer
     */
    public function updateBrand(BrandTransfer $brandTransfer): BrandResponseTransfer;
    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return bool
     */
    public function deleteBrand(BrandTransfer $brandTransfer): bool;

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function findBrandById(BrandTransfer $brandTransfer): ?BrandTransfer;

    /**
     * @param \Generated\Shared\Transfer\BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandCollection(BrandCollectionTransfer $brandCollectionTransfer): BrandCollectionTransfer;
}
