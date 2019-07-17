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
     * @return array
     */
    public function getData(int $idBrand): array
    {
        $brandTransfer = (new BrandTransfer())->setIdBrand($idBrand);

        $brandTransfer = $this->brandFacade->findBrandById($brandTransfer);

        if ($brandTransfer === null) {
            return [];
        }

        return $brandTransfer->toArray();
    }
}
