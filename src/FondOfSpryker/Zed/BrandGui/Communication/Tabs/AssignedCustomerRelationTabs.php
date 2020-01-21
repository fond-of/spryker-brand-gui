<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class AssignedCustomerRelationTabs extends AbstractTabs
{
    public const ASSIGNED_CUSTOMER_TAB_NAME = 'assigned_customer';
    public const ASSIGNED_CUSTOMER_TAB_TITLE = 'Customers in this list';
    public const ASSIGNED_CUSTOMER_TAB_TEMPLATE = '@BrandGui/_partials/_tables/assigned-customer-table.twig';

    public const DEASSIGNED_CUSTOMER_TAB_NAME = 'deassignment_customer';
    public const DEASSIGNED_CUSTOMER_TAB_TITLE = 'Customers to be deassigned';
    public const DEASSIGNED_CUSTOMER_TAB_TEMPLATE = '@BrandGui/_partials/_tables/deassignment-customer-table.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer)
    {
        $this->addAssignedCustomerTab($tabsViewTransfer)
            ->addDeassignmentCustomerTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(false);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAssignedCustomerTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::ASSIGNED_CUSTOMER_TAB_NAME)
            ->setTitle(static::ASSIGNED_CUSTOMER_TAB_TITLE)
            ->setTemplate(static::ASSIGNED_CUSTOMER_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addDeassignmentCustomerTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::DEASSIGNED_CUSTOMER_TAB_NAME)
            ->setTitle(static::DEASSIGNED_CUSTOMER_TAB_TITLE)
            ->setTemplate(static::DEASSIGNED_CUSTOMER_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
