<?php

namespace FondOfSpryker\Zed\BrandGui\Communication;

use FondOfSpryker\Zed\BrandGui\BrandGuiDependencyProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandForm;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Table\BrandTable;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface;
use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \FondOfSpryker\Zed\BrandGui\BrandGuiConfig getConfig()
 */
class BrandGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\BrandTable
     */
    public function createBrandTable(): BrandTable
    {
        return new BrandTable($this->getFosBrandQuery());
    }

    /**
     * @throws
     *
     * @return \Orm\Zed\Brand\Persistence\FosBrandQuery
     */
    protected function getFosBrandQuery(): FosBrandQuery
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::PROPEL_QUERY_FOS_BRAND);
    }

    /**
     * @throws
     *
     * @return \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface
     */
    public function getBrandFacade(): BrandGuiToBrandFacadeInterface
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::FACADE_BRAND);
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider
     */
    public function createBrandFormDataProvider(): BrandFormDataProvider
    {
        return new BrandFormDataProvider($this->getBrandFacade());
    }

    /**
     * @param array $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createBrandForm(array $data = [], array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(BrandForm::class, $data, $options);
    }
}
