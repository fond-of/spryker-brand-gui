<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class BrandAggregationTabs extends AbstractTabs
{
    public const GENERAL_TAB_NAME = 'general';
    public const GENERAL_TAB_TITLE = 'General Information';
    public const GENERAL_TAB_TEMPLATE = '@BrandGui/_partials/_tabs/general-information.twig';
    
    public const CUSTOMERS_TAB_NAME = 'brand_customer_relation';
    public const CUSTOMERS_TAB_TITLE = 'Assign Customers';
    public const CUSTOMERS_TAB_TEMPLATE = '@BrandGui/_partials/_tabs/brand-customer-relation.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $this->addProductListCustomerRelationTab($tabsViewTransfer);
        $this->addProductListCompanyRelationTab($tabsViewTransfer);

        $this->addGeneralInformationTab($tabsViewTransfer)
            ->addBrandCustomerRelationTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(true);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addGeneralInformationTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::GENERAL_TAB_NAME)
            ->setTitle(static::GENERAL_TAB_TITLE)
            ->setTemplate(static::GENERAL_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addCustomerCustomerRelationTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::CUSTOMERS_TAB_NAME)
            ->setTitle(static::CUSTOMERS_TAB_TITLE)
            ->setTemplate(static::CUSTOMERS_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
