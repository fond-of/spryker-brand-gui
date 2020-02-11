<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

class AssignedProductAbstractRelationTabs extends AbstractTabs
{
    public const ASSIGNED_PRODUCT_ABSTRACT_TAB_NAME = 'assigned_product_abstract';
    public const ASSIGNED_PRODUCT_ABSTRACT_TAB_TITLE = 'Product in this list';
    public const ASSIGNED_PRODUCT_ABSTRACT_TAB_TEMPLATE = '@BrandGui/_partials/_tables/assigned-product-abstract-table.twig';

    public const DEASSIGNED_PRODUCT_ABSTRACT_TAB_NAME = 'deassignment_product_abstract';
    public const DEASSIGNED_PRODUCT_TAB_ABSTRACT_TITLE = 'Product to be deassigned';
    public const DEASSIGNED_PRODUCT_ABSTRACT_TAB_TEMPLATE = '@BrandGui/_partials/_tables/deassignment-product-abstract-table.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer)
    {
        $this->addAssignedProductAbstractTab($tabsViewTransfer)
            ->addDeassignmentProductAbstractTab($tabsViewTransfer);

        $tabsViewTransfer->setIsNavigable(false);

        return $tabsViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addAssignedProductAbstractTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::ASSIGNED_PRODUCT_ABSTRACT_TAB_NAME)
            ->setTitle(static::ASSIGNED_PRODUCT_ABSTRACT_TAB_TITLE)
            ->setTemplate(static::ASSIGNED_PRODUCT_ABSTRACT_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return $this
     */
    protected function addDeassignmentProductAbstractTab(TabsViewTransfer $tabsViewTransfer)
    {
        $tabItemTransfer = new TabItemTransfer();
        $tabItemTransfer
            ->setName(static::DEASSIGNED_PRODUCT_ABSTRACT_TAB_NAME)
            ->setTitle(static::DEASSIGNED_PRODUCT_TAB_ABSTRACT_TITLE)
            ->setTemplate(static::DEASSIGNED_PRODUCT_ABSTRACT_TAB_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $this;
    }
}
