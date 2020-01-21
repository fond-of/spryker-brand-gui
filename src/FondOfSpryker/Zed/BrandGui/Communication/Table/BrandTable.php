<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use FondOfSpryker\Zed\BrandGui\Communication\Controller\BrandAbstractController;
use FondOfSpryker\Zed\BrandGui\Communication\Controller\RoutingConstants;
use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Orm\Zed\Brand\Persistence\Map\FosBrandTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class BrandTable extends AbstractTable
{
    protected const COLUMN_ID_BRAND = FosBrandTableMap::COL_ID_BRAND;
    protected const COLUMN_NAME = FosBrandTableMap::COL_NAME;
    protected const COLUMN_ACTIONS = 'actions';

    public const URL_BRAND_EDIT = RoutingConstants::URL_EDIT;
    public const URL_BRAND_DELETE = RoutingConstants::URL_DELETE;

    /**
     * @var \Orm\Zed\Brand\Persistence\FosBrandQuery
     */
    protected $brandQuery;

    /**
     * @param \Orm\Zed\Brand\Persistence\FosBrandQuery $brandQuery
     */
    public function __construct(FosBrandQuery $brandQuery)
    {
        $this->brandQuery = $brandQuery;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $queryResults = $this->runQuery($this->brandQuery, $config);

        $results = [];

        foreach ($queryResults as $item) {
            $rowData = [
                static::COLUMN_ID_BRAND => $item[FosBrandTableMap::COL_ID_BRAND],
                static::COLUMN_NAME => $item[FosBrandTableMap::COL_NAME],
                static::COLUMN_ACTIONS => $this->buildLinks($item),
            ];

            $results[] = $rowData;
        }

        unset($queryResults);

        return $results;
    }

    /**
     * @param array $item
     *
     * @return string
     */
    protected function buildLinks(array $item): string
    {
        $buttons = [];

        $editUrl = Url::generate(static::URL_BRAND_EDIT, [BrandAbstractController::URL_PARAM_ID_BRAND => $item[FosBrandTableMap::COL_ID_BRAND]]);
        $deleteUrl = Url::generate(static::URL_BRAND_DELETE, [BrandAbstractController::URL_PARAM_ID_BRAND => $item[FosBrandTableMap::COL_ID_BRAND]]);

        $buttons[] = $this->generateEditButton($editUrl, 'Edit Brand');
        $buttons[] = $this->generateRemoveButton($deleteUrl, 'Remove Brand');

        return implode(' ', $buttons);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config = $this->setHeader($config);
        $config->addRawColumn(static::COLUMN_ACTIONS);

        $config->setSortable(
            [
                static::COLUMN_ID_BRAND,
                static::COLUMN_NAME,
            ]
        );

        $config->setSearchable(
            [
                static::COLUMN_ID_BRAND,
                static::COLUMN_NAME,
            ]
        );

        $config->setDefaultSortField(static::COLUMN_ID_BRAND, TableConfiguration::SORT_DESC);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function setHeader(TableConfiguration $config): TableConfiguration
    {
        $baseData = [
            static::COLUMN_ID_BRAND => 'ID',
            static::COLUMN_NAME => 'Name',
        ];

        $actions = [static::COLUMN_ACTIONS => 'Actions'];

        $config->setHeader($baseData + $actions);

        return $config;
    }
}
