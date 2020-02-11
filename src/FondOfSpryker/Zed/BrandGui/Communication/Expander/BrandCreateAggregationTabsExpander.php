<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Expander;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;

class BrandCreateAggregationTabsExpander implements BrandCreateAggregationTabsExpanderInterface
{
    public const CUSTOMERS_TAB_NAME = 'brand_customer_relation';
    public const CUSTOMERS_TAB_TITLE = 'Assign Customers';
    public const CUSTOMERS_TAB_TEMPLATE = '@BrandGui/_partials/_tabs/brand-customer-relation.twig';

    public const COMPANIES_TAB_NAME = 'brand_company_relation';
    public const COMPANIES_TAB_TITLE = 'Assign Companies';
    public const COMPANIES_TAB_TEMPLATE = '@BrandGui/_partials/_tabs/brand-company-relation.twig';

    public const PRODUCT_ABSTRACT_TAB_NAME = 'brand_product_abstract_relation';
    public const PRODUCT_ABSTRACT_TAB_TITLE = 'Assign Products';
    public const PRODUCT_ABSTRACT_TAB_TEMPLATE = '@BrandGui/_partials/_tabs/brand-product-abstract-relation.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expandWithBrandAssignmentTabs(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $this->addBrandCustomerRelationTab($tabsViewTransfer)
            ->addBrandCompanyRelationTab($tabsViewTransfer)
            ->addBrandProductAbstractRelationTab($tabsViewTransfer);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addBrandCustomerRelationTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = (new TabItemTransfer())
            ->setName(static::CUSTOMERS_TAB_NAME)
            ->setTitle(static::CUSTOMERS_TAB_TITLE)
            ->setTemplate(static::CUSTOMERS_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addBrandCompanyRelationTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = (new TabItemTransfer())
            ->setName(static::COMPANIES_TAB_NAME)
            ->setTitle(static::COMPANIES_TAB_TITLE)
            ->setTemplate(static::COMPANIES_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addBrandProductAbstractRelationTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = (new TabItemTransfer())
            ->setName(static::PRODUCT_ABSTRACT_TAB_NAME)
            ->setTitle(static::PRODUCT_ABSTRACT_TAB_TITLE)
            ->setTemplate(static::PRODUCT_ABSTRACT_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
