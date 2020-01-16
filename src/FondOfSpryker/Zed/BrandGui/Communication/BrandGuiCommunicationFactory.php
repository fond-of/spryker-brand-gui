<?php

namespace FondOfSpryker\Zed\BrandGui\Communication;

use FondOfSpryker\Zed\BrandGui\BrandGuiDependencyProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandAggregateFormType;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandForm;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandAggregateFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCustomerRelationFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedCustomerTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\BrandTable;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AssignedCustomerRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AvailableCustomerRelationTabs;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeInterface;
use FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCustomerTable;
use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Gui\Communication\Tabs\TabsInterface;
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
     * @throws
     *
     * @return \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeInterface
     */
    public function getCustomerFacade(): BrandGuiToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::FACADE_CUSTOMER);
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

    /**
     * @return \FondOfSpryker\Zed\ProductListGui\Communication\Table\AvailableCustomerTable
     */
    public function createAvailableCustomerTable(): AvailableCustomerTable
    {
        return new AvailableCustomerTable($this->getCustomerPropelQuery());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAvailableCustomerRelationTabs(): TabsInterface
    {
        return new AvailableCustomerRelationTabs();
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAssignedCustomerRelationTabs(): TabsInterface
    {
        return new AssignedCustomerRelationTabs();
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCustomerRelationFormDataProvider
     */
    public function createBrandCustomerRelationFormDataProvider(): BrandCustomerRelationFormDataProvider
    {
        return new BrandCustomerRelationFormDataProvider(
            $this->getBrandFacade(),
            $this->getCustomerFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandAggregateFormDataProvider
     */
    public function createBrandAggregateFormDataProvider(): BrandAggregateFormDataProvider
    {
        return new BrandAggregateFormDataProvider(
            $this->createBrandFormDataProvider(),
            $this->createBrandCustomerRelationFormDataProvider()
        );
    }

    public function getBrandAggregateForm(
        ?BrandAggregateFormTransfer $brandAggregateFormTransfer = null,
        array $options = []
    ): FormInterface {
        return $this
            ->getFormFactory()
            ->create(
                BrandAggregateFormType::class,
                $brandAggregateFormTransfer,
                $options
            );
    }

    /**
     * @throws
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerPropelQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedCustomerTable
     */
    public function createAssignedCustomerTable(): AssignedCustomerTable
    {
        return new AssignedCustomerTable($this->getCustomerPropelQuery());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createProductListEditAggregationTabs(): TabsInterface
    {
        return new Brand($this->createProductListCreateAggregationTabsExpander());
    }
}
