<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;

class AssignedProductAbstractTable extends AbstractProductAbstractTable
{
    protected const DEFAULT_URL = 'assigned-product-abstract-table';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstractQuery $spyProductAbstractQuery
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    protected function filterQuery(SpyProductAbstractQuery $spyProductAbstractQuery): SpyProductAbstractQuery
    {
        $spyProductAbstractQuery
            ->useFosBrandProductQuery()
            ->filterByFkBrand($this->getIdBrand())
            ->endUse();

        return $spyProductAbstractQuery;
    }
}
