<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Tabs;

use Generated\Shared\Transfer\TabsViewTransfer;

class BrandEditAggregationTabs extends AbstractBrandAggregationTabs
{
    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabsViewTransfer = parent::build($tabsViewTransfer);

        return $tabsViewTransfer;
    }
}
