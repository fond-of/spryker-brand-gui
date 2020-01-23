<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\BrandCompany\Persistence\Map\FosBrandCompanyTableMap;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria;

class AvailableCompanyTable extends AbstractCompanyTable
{
    protected const DEFAULT_URL = 'available-company-table';
    protected const TABLE_IDENTIFIER = self::DEFAULT_URL;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $companyQuery
     *
     * @throws
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function filterQuery(SpyCompanyQuery $companyQuery): SpyCompanyQuery
    {
        if ($this->getIdBrand()) {
            $companyQuery
                ->useFosBrandCompanyQuery(
                    FosBrandCompanyTableMap::TABLE_NAME,
                    Criteria::LEFT_JOIN
                )
                ->filterByFkBrand(null, Criteria::ISNULL)
                ->endUse()
                ->addJoinCondition(
                    FosBrandCompanyTableMap::TABLE_NAME,
                    sprintf(
                        '%s = %d',
                        FosBrandCompanyTableMap::COL_FK_BRAND,
                        $this->getIdBrand()
                    )
                );
        }

        return $companyQuery;
    }
}
