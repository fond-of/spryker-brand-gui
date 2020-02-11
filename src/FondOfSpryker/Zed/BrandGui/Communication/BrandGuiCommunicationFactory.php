<?php

namespace FondOfSpryker\Zed\BrandGui\Communication;

use FondOfSpryker\Zed\BrandGui\BrandGuiDependencyProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormDataProviderExpander;
use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormDataProviderExpanderInterface;
use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormExpander;
use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormExpanderInterface;
use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandCreateAggregationTabsExpander;
use FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandCreateAggregationTabsExpanderInterface;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandAggregateFormType;
use FondOfSpryker\Zed\BrandGui\Communication\Form\BrandForm;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandAggregateFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCompanyRelationFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCustomerRelationFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandFormDataProvider;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedCompanyTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedCustomerTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedProductAbstractTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AvailableCompanyTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AvailableCustomerTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\AvailableProductAbstractTable;
use FondOfSpryker\Zed\BrandGui\Communication\Table\BrandTable;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AssignedCompanyRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AssignedCustomerRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AssignedProductAbstractRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AvailableCompanyRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AvailableCustomerRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\AvailableProductAbstractRelationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\BrandCreateAggregationTabs;
use FondOfSpryker\Zed\BrandGui\Communication\Tabs\BrandEditAggregationTabs;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeInterface;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCompanyFacadeInterface;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeInterface;
use Generated\Shared\Transfer\BrandAggregateFormTransfer;
use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
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
     * @throws
     *
     * @return \FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCompanyFacadeInterface
     */
    public function getCompanyFacade(): BrandGuiToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::FACADE_COMPANY);
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
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AvailableCustomerTable
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
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AvailableCompanyTable
     */
    public function createAvailableCompanyTable(): AvailableCompanyTable
    {
        return new AvailableCompanyTable($this->getCompanyPropelQuery());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAvailableCompanyRelationTabs(): TabsInterface
    {
        return new AvailableCompanyRelationTabs();
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAssignedCompanyRelationTabs(): TabsInterface
    {
        return new AssignedCompanyRelationTabs();
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandCompanyRelationFormDataProvider
     */
    public function createBrandCompanyRelationFormDataProvider(): BrandCompanyRelationFormDataProvider
    {
        return new BrandCompanyRelationFormDataProvider(
            $this->getBrandFacade(),
            $this->getCompanyFacade()
        );
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAssignedProductAbstractRelationTabs(): TabsInterface
    {
        return new AssignedProductAbstractRelationTabs();
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedProductAbstractTable
     */
    public function createAssignedProductAbstractTable(): AssignedProductAbstractTable
    {
        return new AssignedProductAbstractTable($this->getProductAbstractPropelQuery());
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AvailableProductAbstractTable
     */
    public function createAvailableProductAbstractTable(): AvailableProductAbstractTable
    {
        return new AvailableProductAbstractTable($this->getProductAbstractPropelQuery());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createAvailableProductAbstractRelationTabs(): TabsInterface
    {
        return new AvailableProductAbstractRelationTabs();
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Form\DataProvider\BrandAggregateFormDataProvider
     */
    public function createBrandAggregateFormDataProvider(): BrandAggregateFormDataProvider
    {
        return new BrandAggregateFormDataProvider(
            $this->createBrandFormDataProvider(),
            $this->createBrandAggregateFormDataProviderExpander()
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
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormExpanderInterface
     */
    public function createBrandAggregateFormExpander(): BrandAggregateFormExpanderInterface
    {
        return new BrandAggregateFormExpander();
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandAggregateFormDataProviderExpanderInterface
     */
    public function createBrandAggregateFormDataProviderExpander(): BrandAggregateFormDataProviderExpanderInterface
    {
        return new BrandAggregateFormDataProviderExpander();
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedCustomerTable
     */
    public function createAssignedCustomerTable(): AssignedCustomerTable
    {
        return new AssignedCustomerTable($this->getCustomerPropelQuery());
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
     * @throws
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    public function getCompanyPropelQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::PROPEL_QUERY_COMPANY);
    }

    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function getProductAbstractPropelQuery(): SpyProductAbstractQuery
    {
        return $this->getProvidedDependency(BrandGuiDependencyProvider::PROPEL_QUERY_PRODUCT_ABSTRACT);
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Table\AssignedCompanyTable
     */
    public function createAssignedCompanyTable(): AssignedCompanyTable
    {
        return new AssignedCompanyTable($this->getCompanyPropelQuery());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createBrandEditAggregationTabs(): TabsInterface
    {
        return new BrandEditAggregationTabs($this->createBrandCreateAggregationTabsExpander());
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createBrandCreateAggregationTabs(): TabsInterface
    {
        return new BrandCreateAggregationTabs($this->createBrandCreateAggregationTabsExpander());
    }

    /**
     * @return \FondOfSpryker\Zed\BrandGui\Communication\Expander\BrandCreateAggregationTabsExpanderInterface
     */
    public function createBrandCreateAggregationTabsExpander(): BrandCreateAggregationTabsExpanderInterface
    {
        return new BrandCreateAggregationTabsExpander();
    }
}
