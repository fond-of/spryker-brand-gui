<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class AssignedCompanyRelationTabs extends AbstractTabs
{
    public const ASSIGNED_COMPANY_TAB_NAME = 'assigned_company';
    public const ASSIGNED_COMPANY_TAB_TITLE = 'Company in this list';
    public const ASSIGNED_COMPANY_TAB_TEMPLATE = '@BrandGui/_partials/_tables/assigned-company-table.twig';

    public const DEASSIGNED_COMPANY_TAB_NAME = 'deassignment_company';
    public const DEASSIGNED_COMPANY_TAB_TITLE = 'Company to be deassigned';
    public const DEASSIGNED_COMPANY_TAB_TEMPLATE = '@BrandGui/_partials/_tables/deassignment-company-table.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer)
    {
        $this->addAssignedCompanyTab($tabsViewTransfer)
            ->addDeassignmentCompanyTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(false);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAssignedCompanyTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::ASSIGNED_COMPANY_TAB_NAME)
            ->setTitle(static::ASSIGNED_COMPANY_TAB_TITLE)
            ->setTemplate(static::ASSIGNED_COMPANY_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addDeassignmentCompanyTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::DEASSIGNED_COMPANY_TAB_NAME)
            ->setTitle(static::DEASSIGNED_COMPANY_TAB_TITLE)
            ->setTemplate(static::DEASSIGNED_COMPANY_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
