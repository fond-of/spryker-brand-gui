<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\BrandCustomer\Persistence\Map\FosBrandCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

class AvailableCustomerTable extends AbstractCustomerTable
{
    protected const DEFAULT_URL = 'available-customer-table';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $customerQuery
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function filterQuery(SpyCustomerQuery $customerQuery): SpyCustomerQuery
    {
        if ($this->getIdBrand()) {
            $customerQuery
                ->useFosBrandCustomerQuery(
                    FosBrandCustomerTableMap::TABLE_NAME,
                    Criteria::LEFT_JOIN
                )
                ->filterByFkBrand(null, Criteria::ISNULL)
                ->endUse()
                ->addJoinCondition(
                    FosBrandCustomerTableMap::TABLE_NAME,
                    sprintf(
                        '%s = %d',
                        FosBrandCustomerTableMap::COL_FK_BRAND,
                        $this->getIdBrand()
                    )
                );
        }

        return $customerQuery;
    }
}
