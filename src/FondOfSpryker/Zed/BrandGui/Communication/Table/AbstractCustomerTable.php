<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use FondOfSpryker\Zed\BrandGui\Communication\Controller\BrandAbstractController;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

abstract class AbstractCustomerTable extends AbstractTable
{
    protected const DEFAULT_URL = 'table';
    protected const TABLE_IDENTIFIER = 'table';

    protected const COLUMN_ID = SpyCustomerTableMap::COL_ID_CUSTOMER;
    protected const COLUMN_FIRST_NAME = SpyCustomerTableMap::COL_FIRST_NAME;
    protected const COLUMN_LAST_NAME = SpyCustomerTableMap::COL_LAST_NAME;
    protected const COLUMN_EMAIL = SpyCustomerTableMap::COL_EMAIL;
    protected const COLUMN_ACTION = 'action';

    /**
     * @var \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected $spyCustomerQuery;

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $spyCustomerQuery
     */
    public function __construct(SpyCustomerQuery $spyCustomerQuery)
    {
        $this->spyCustomerQuery = $spyCustomerQuery;
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
            static::COLUMN_FIRST_NAME => 'First Name',
            static::COLUMN_LAST_NAME => 'Last Name',
            static::COLUMN_EMAIL => 'Email',
            static::COLUMN_ACTION => 'Selected',
        ]);

        $config->setSearchable([
            static::COLUMN_ID,
            static::COLUMN_FIRST_NAME,
            static::COLUMN_LAST_NAME,
            static::COLUMN_EMAIL,
        ]);

        $config->setSortable([
            static::COLUMN_ID,
            static::COLUMN_FIRST_NAME,
            static::COLUMN_LAST_NAME,
            static::COLUMN_EMAIL,
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
        $tableUrl = ($config->getUrl() === null) ? $this->defaultUrl : $config->getUrl();

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
        $spyCustomerQuery = $this->buildQuery();
        $queryResults = $this->runQuery($spyCustomerQuery, $config);
        $results = [];

        foreach ($queryResults as $customerData) {
            $results[] = $this->buildDataRow($customerData);
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
            static::COLUMN_ID => $customer[SpyCustomerTableMap::COL_ID_CUSTOMER],
            static::COLUMN_FIRST_NAME => $customer[SpyCustomerTableMap::COL_FIRST_NAME],
            static::COLUMN_LAST_NAME => $customer[SpyCustomerTableMap::COL_LAST_NAME],
            static::COLUMN_EMAIL => $customer[SpyCustomerTableMap::COL_EMAIL],
            static::COLUMN_ACTION => sprintf(
                '<input class="%s-all-customers-checkbox" type="checkbox"  value="%d">',
                static::TABLE_IDENTIFIER,
                $customer[SpyCustomerTableMap::COL_ID_CUSTOMER]
            ),
        ];
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected function buildQuery(): SpyCustomerQuery
    {
        $this->spyCustomerQuery
            ->select(
                [
                    SpyCustomerTableMap::COL_ID_CUSTOMER,
                    SpyCustomerTableMap::COL_FIRST_NAME,
                    SpyCustomerTableMap::COL_LAST_NAME,
                    SpyCustomerTableMap::COL_EMAIL,
                ]
            );

        return $this->filterQuery($this->spyCustomerQuery);
    }

    /**
     * @return int
     */
    protected function getIdBrand(): int
    {
        return $this->request->query->getInt(BrandAbstractController::URL_PARAM_ID_BRAND, 0);
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $spyCustomerQuery
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    abstract protected function filterQuery(SpyCustomerQuery $spyCustomerQuery): SpyCustomerQuery;
}
