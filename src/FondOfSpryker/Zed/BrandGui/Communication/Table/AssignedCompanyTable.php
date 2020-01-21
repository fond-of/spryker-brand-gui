<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;

class AssignedCompanyTable extends AbstractCompanyTable
{
    protected const DEFAULT_URL = 'assignedCompanyTable';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     *
     * @throws
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function filterQuery(SpyCompanyQuery $spyCompanyQuery): SpyCompanyQuery
    {
        $spyCompanyQuery
            ->useFosBrandCompanyQuery()
            ->filterByFkBrand($this->getIdBrand())
            ->endUse();

        return $spyCompanyQuery;
    }
}
