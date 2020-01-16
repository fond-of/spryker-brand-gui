<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Gui\Communication\Tabs\AbstractTabs;

abstract class AbstractBrandAggregationTabs extends AbstractTabs
{
    public const GENERAL_TAB_NAME = 'general';
    public const GENERAL_TAB_TITLE = 'General Information';
    public const GENERAL_TAB_TEMPLATE = '@BrandGui/_partials/_tabs/general-information.twig';

    protected $brandCreateAggregationTabsExpander;

    /**
     * @param \Spryker\Zed\ProductListGui\Communication\Expander\ProductListCreateAggregationTabsExpanderInterface $productListCreateAggregationTabsExpander
     */
    public function __construct(BrandCreateAggregationTabsExpanderInterface $productListCreateAggregationTabsExpander)
    {
        $this->productListCreateAggregationTabsExpander = $productListCreateAggregationTabsExpander;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $this->addGeneralInformationTab($tabsViewTransfer)
            ->setFooter($tabsViewTransfer);

        $tabsViewTransfer = $this->productListCreateAggregationTabsExpander->expandWithProductListAssignmentTabs($tabsViewTransfer);

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
    protected function setFooter(TabsViewTransfer $tabsViewTransfer)
    {
        $tabsViewTransfer->setFooterTemplate('@ProductListGui/_partials/_tabs/submit-button.twig');

        return $this;
    }
}
