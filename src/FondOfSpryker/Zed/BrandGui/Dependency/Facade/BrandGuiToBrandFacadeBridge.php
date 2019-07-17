<?php

namespace FondOfSpryker\Zed\BrandGui\Dependency\Facade;

use FondOfSpryker\Zed\Brand\Business\BrandFacadeInterface;
use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandResponseTransfer;
use Generated\Shared\Transfer\BrandTransfer;

class BrandGuiToBrandFacadeBridge implements BrandGuiToBrandFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\Brand\Business\BrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @param \FondOfSpryker\Zed\Brand\Business\BrandFacadeInterface $brandFacade
     */
    public function __construct(BrandFacadeInterface $brandFacade)
    {
        $this->brandFacade = $brandFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandResponseTransfer
     */
    public function addBrand(BrandTransfer $brandTransfer): BrandResponseTransfer
    {
        return $this->brandFacade->addBrand($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandResponseTransfer
     */
    public function updateBrand(BrandTransfer $brandTransfer): BrandResponseTransfer
    {
        return $this->brandFacade->updateBrand($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return bool
     */
    public function deleteBrand(BrandTransfer $brandTransfer): bool
    {
        return $this->brandFacade->deleteBrand($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandTransfer $brandTransfer
     *
     * @return \Generated\Shared\Transfer\BrandTransfer|null
     */
    public function findBrandById(BrandTransfer $brandTransfer): ?BrandTransfer
    {
        return $this->brandFacade->findBrandById($brandTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\BrandCollectionTransfer $brandCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\BrandCollectionTransfer
     */
    public function getBrandCollection(BrandCollectionTransfer $brandCollectionTransfer): BrandCollectionTransfer
    {
        return $this->brandFacade->getBrandCollection($brandCollectionTransfer);
    }
}
