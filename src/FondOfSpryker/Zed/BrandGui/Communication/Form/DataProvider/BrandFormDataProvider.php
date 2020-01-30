<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider;

use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface;
use Generated\Shared\Transfer\BrandTransfer;

class BrandFormDataProvider
{
    /**
     * @var \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface
     */
    protected $brandFacade;

    /**
     * @param \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface $brandFacade
     */
    public function __construct(BrandGuiToBrandFacadeInterface $brandFacade)
    {
        $this->brandFacade = $brandFacade;
    }

    /**
     * @param int $idBrand
     *
     * @return \Generated\Shared\Transfer\BrandTransfer
     */
    public function getData(int $idBrand): BrandTransfer
    {
        $brandTransfer = new BrandTransfer();

        if (!$idBrand) {
            return $brandTransfer;
        }

        $brandTransfer->setIdBrand($idBrand);

        return $this->brandFacade->findBrandById($brandTransfer);
    }
}
