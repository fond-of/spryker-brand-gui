<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\BrandProduct\Persistence\Map\FosBrandProductTableMap;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

class AvailableProductAbstractTable extends AbstractProductAbstractTable
{
    protected const DEFAULT_URL = 'available-product-abstract-table';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    protected function filterQuery(SpyProductAbstractQuery $productAbstractQuery): SpyProductAbstractQuery
    {
        if ($this->getIdBrand()) {
            $productAbstractQuery
                ->useFosBrandProductQuery(
                    FosBrandProductTableMap::TABLE_NAME,
                    Criteria::LEFT_JOIN
                )
                ->filterByFkBrand(null, Criteria::ISNULL)
                ->endUse()
                ->addJoinCondition(
                    FosBrandProductTableMap::TABLE_NAME,
                    sprintf(
                        '%s = %d',
                        FosBrandProductTableMap::COL_FK_BRAND,
                        $this->getIdBrand()
                    )
                );
        }

        return $productAbstractQuery;
    }
}
