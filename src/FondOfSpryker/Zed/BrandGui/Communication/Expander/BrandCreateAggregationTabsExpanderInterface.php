<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Expander;

use Generated\Shared\Transfer\TabsViewTransfer;

interface BrandCreateAggregationTabsExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expandWithBrandAssignmentTabs(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer;
}
