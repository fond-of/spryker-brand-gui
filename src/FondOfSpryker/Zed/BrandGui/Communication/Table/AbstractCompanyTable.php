<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use FondOfSpryker\Zed\BrandGui\Communication\Controller\BrandAbstractController;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

abstract class AbstractCompanyTable extends AbstractTable
{
    protected const DEFAULT_URL = 'table';
    protected const TABLE_IDENTIFIER = 'table';

    protected const COLUMN_ID = SpyCompanyTableMap::COL_ID_COMPANY;
    protected const COLUMN_NAME = SpyCompanyTableMap::COL_NAME;
    protected const COLUMN_ACTION = 'action';

    /**
     * @var \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected $spyCompanyQuery;

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     */
    public function __construct(
        SpyCompanyQuery $spyCompanyQuery
    ) {
        $this->spyCompanyQuery = $spyCompanyQuery;
        $this->defaultUrl = static::DEFAULT_URL;
        $this->setTableIdentifier(static::TABLE_IDENTIFIER);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            static::COLUMN_ID => 'ID',
            static::COLUMN_NAME => 'Name',
            static::COLUMN_ACTION => 'Selected',
        ]);

        $config->setSearchable([
            static::COLUMN_ID,
            static::COLUMN_NAME,
        ]);

        $config->setSortable([
            static::COLUMN_ID,
            static::COLUMN_NAME,
        ]);

        $config->addRawColumn(self::COLUMN_ACTION);
        $config->setUrl($this->getTableUrl($config));

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return string
     */
    protected function getTableUrl(TableConfiguration $config): string
    {
        $tableUrl = $config->getUrl() ?? $this->defaultUrl;

        if ($this->getIdBrand()) {
            $tableUrl = Url::generate($tableUrl, [BrandAbstractController::URL_PARAM_ID_BRAND => $this->getIdBrand()]);
        }

        return $tableUrl;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $spyCompanyQuery = $this->buildQuery();
        $queryResults = $this->runQuery($spyCompanyQuery, $config);
        $results = [];

        foreach ($queryResults as $companyData) {
            $results[] = $this->buildDataRow($companyData);
        }

        unset($queryResults);

        return $results;
    }

    /**
     * @param string[] $customer
     *
     * @return string[]
     */
    protected function buildDataRow(array $customer): array
    {
        return [
            static::COLUMN_ID => $customer[SpyCompanyTableMap::COL_ID_COMPANY],
            static::COLUMN_NAME => $customer[SpyCompanyTableMap::COL_NAME],
            static::COLUMN_ACTION => sprintf(
                '<input class="%s-all-customers-checkbox" type="checkbox"  value="%d">',
                static::TABLE_IDENTIFIER,
                $customer[SpyCompanyTableMap::COL_ID_COMPANY]
            ),
        ];
    }

    /**
     * @throws
     *
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     */
    protected function buildQuery(): SpyCompanyQuery
    {
        $this->spyCompanyQuery
            ->select(
                [
                    SpyCompanyTableMap::COL_ID_COMPANY,
                    SpyCompanyTableMap::COL_NAME,
                ]
            );

        return $this->filterQuery($this->spyCompanyQuery);
    }

    /**
     * @return int
     */
    protected function getIdBrand(): int
    {
        return $this->request->query->getInt(BrandAbstractController::URL_PARAM_ID_BRAND, 0);
    }

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompanyQuery $spyCompanyQuery
     *
     * @return
     */
    abstract protected function filterQuery(SpyCompanyQuery $spyCompanyQuery): SpyCompanyQuery;
}
