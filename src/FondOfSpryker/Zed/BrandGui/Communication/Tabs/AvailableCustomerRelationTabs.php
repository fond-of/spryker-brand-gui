<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class AvailableCustomerRelationTabs extends AbstractTabs
{
    public const AVAILABLE_TAB_NAME = 'available_customer';
    public const AVAILABLE_TAB_TITLE = 'Select Customers to assign';
    public const AVAILABLE_TAB_TEMPLATE = '@BrandGui/_partials/_tables/available-customer-table.twig';

    public const ASSIGNED_TAB_NAME = 'assignment_customer';
    public const ASSIGNED_TAB_TITLE = 'Customers to be assigned';
    public const ASSIGNED_TAB_TEMPLATE = '@BrandGui/_partials/_tables/assignment-customer-table.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer)
    {
        $this->addAvailableCustomerTab($tabsViewTransfer)
            ->addAssignmentCustomerTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(false);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAvailableCustomerTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::AVAILABLE_TAB_NAME)
            ->setTitle(static::AVAILABLE_TAB_TITLE)
            ->setTemplate(static::AVAILABLE_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAssignmentCustomerTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::ASSIGNED_TAB_NAME)
            ->setTitle(static::ASSIGNED_TAB_TITLE)
            ->setTemplate(static::ASSIGNED_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
