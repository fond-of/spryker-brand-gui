<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use FondOfSpryker\Zed\BrandGui\Communication\Controller\BrandAbstractController;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

abstract class AbstractProductAbstractTable extends AbstractTable
{
    protected const DEFAULT_URL = 'table';
    protected const TABLE_IDENTIFIER = 'table';

    protected const COLUMN_ID = SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT;
    protected const COLUMN_SKU = SpyProductAbstractTableMap::COL_SKU;
    protected const COLUMN_ACTION = 'action';

    /**
     * @var \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    protected $spyProductAbstractQuery;

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstractQuery $spyProductAbstractQuery
     */
    public function __construct(
        SpyProductAbstractQuery $spyProductAbstractQuery
    ) {
        $this->spyProductAbstractQuery = $spyProductAbstractQuery;
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
            static::COLUMN_SKU => 'Sku',
            static::COLUMN_ACTION => 'Selected',
        ]);

        $config->setSearchable([
            static::COLUMN_ID,
            static::COLUMN_SKU,
        ]);

        $config->setSortable([
            static::COLUMN_ID,
            static::COLUMN_SKU,
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
        $spyProductAbstractQuery = $this->buildQuery();
        $queryResults = $this->runQuery($spyProductAbstractQuery, $config);
        $results = [];

        foreach ($queryResults as $productAbstractData) {
            $results[] = $this->buildDataRow($productAbstractData);
        }

        unset($queryResults);

        return $results;
    }

    /**
     * @param string[] $product
     *
     * @return string[]
     */
    protected function buildDataRow(array $product): array
    {
        return [
            static::COLUMN_ID => $product[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT],
            static::COLUMN_SKU => $product[SpyProductAbstractTableMap::COL_SKU],
            static::COLUMN_ACTION => sprintf(
                '<input class="%s-all-product-abstracts-checkbox" type="checkbox"  value="%d">',
                static::TABLE_IDENTIFIER,
                $product[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT]
            ),
        ];
    }

    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    protected function buildQuery(): SpyProductAbstractQuery
    {
        $this->spyProductAbstractQuery
            ->select(
                [
                    SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
                    SpyProductAbstractTableMap::COL_SKU,
                ]
            );

        return $this->filterQuery($this->spyProductAbstractQuery);
    }

    /**
     * @return int
     */
    protected function getIdBrand(): int
    {
        return $this->request->query->getInt(BrandAbstractController::URL_PARAM_ID_BRAND, 0);
    }

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAbstractQuery $spyProductAbstractQuery
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    abstract protected function filterQuery(SpyProductAbstractQuery $spyProductAbstractQuery): SpyProductAbstractQuery;
}
