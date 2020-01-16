<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

class AvailableCustomerTable extends AbstractCustomerTable
{
    protected const DEFAULT_URL = 'availableCustomerTable';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $spyCustomerQuery
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function filterQuery(SpyCustomerQuery $spyCustomerQuery): SpyCustomerQuery
    {
        if ($this->getIdProductList()) {
            $spyCustomerQuery
                ->useSpyProductListCustomerQuery(null, Criteria::LEFT_JOIN)
                    ->filterByFkProductList($this->getIdProductList(), Criteria::NOT_IN)
                    ->_or()
                    ->filterByFkProductList(null, Criteria::ISNULL)
                ->endUse()
                ->distinct();
        }

        return $spyCustomerQuery;
    }
}
