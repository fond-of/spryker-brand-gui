<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;

class AssignedCustomerTable extends AbstractCustomerTable
{
    protected const DEFAULT_URL = 'assigned-customer-table';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $spyCustomerQuery
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function filterQuery(SpyCustomerQuery $spyCustomerQuery): SpyCustomerQuery
    {
        $spyCustomerQuery
            ->useFosBrandCustomerQuery()
                ->filterByFkBrand($this->getIdBrand())
            ->endUse();

        return $spyCustomerQuery;
    }
}
