<?php

namespace FondOfSpryker\Zed\BrandGui\Communication\Table;

use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Orm\Zed\Brand\Persistence\Map\FosBrandTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class BrandTable extends AbstractTable
{
    public const ACTIONS = 'Actions';
    public const URL_PARAMETER_ID_BRAND = 'id-brand';
    public const URL_UPDATE_BRAND = '/brand-gui/brand/update';
    public const URL_DELETE_BRAND = '/brand-gui/brand/delete';

    /**
     * @var \Orm\Zed\Brand\Persistence\Base\FosBrandQuery
     */
    protected $fosBrandQuery;

    /**
     * @param \Orm\Zed\Brand\Persistence\FosBrandQuery $fosBrandQuery
     */
    public function __construct(
        FosBrandQuery $fosBrandQuery
    ) {
        $this->fosBrandQuery = $fosBrandQuery;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            FosBrandTableMap::COL_ID_BRAND => '#',
            FosBrandTableMap::COL_NAME => 'Name',
            FosBrandTableMap::COL_URL => 'Url',
            FosBrandTableMap::COL_IS_ACTIVE => 'Status',
            static::ACTIONS => static::ACTIONS,
        ]);

        $config->addRawColumn(static::ACTIONS)
            ->addRawColumn(FosBrandTableMap::COL_IS_ACTIVE);

        $config->setSortable([
            FosBrandTableMap::COL_NAME,
            FosBrandTableMap::COL_IS_ACTIVE,
        ]);

        $config->setSearchable([
            FosBrandTableMap::COL_NAME,
        ]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $results = [];
        $query = $this->fosBrandQuery;
        $queryResults = $this->runQuery($query, $config);

        foreach ($queryResults as $queryResult) {
            $results[] = [
                FosBrandTableMap::COL_ID_BRAND => $queryResult[FosBrandTableMap::COL_ID_BRAND],
                FosBrandTableMap::COL_NAME => $queryResult[FosBrandTableMap::COL_NAME],
                FosBrandTableMap::COL_URL => $queryResult[FosBrandTableMap::COL_URL],
                FosBrandTableMap::COL_IS_ACTIVE => $this->createStatusLabel($queryResult[FosBrandTableMap::COL_URL]),
                self::ACTIONS => implode(' ', $this->createTableActions($queryResult)),
            ];
        }

        return $results;
    }

    /**
     * @param array $queryResult
     *
     * @return array
     */
    protected function createTableActions(array $queryResult): array
    {
        $buttons = [];

        $buttons[] = $this->generateEditButton(
            Url::generate(static::URL_UPDATE_BRAND, [
                static::URL_PARAMETER_ID_BRAND => $queryResult[FosBrandTableMap::COL_ID_BRAND],
            ]),
            'Edit'
        );

        $buttons[] = $this->generateRemoveButton(
            Url::generate(static::URL_DELETE_BRAND, [
                static::URL_PARAMETER_ID_BRAND => $queryResult[FosBrandTableMap::COL_ID_BRAND],
            ]),
            'Delete'
        );

        return $buttons;
    }

    /**
     * @param bool $isActive
     *
     * @return string
     */
    protected function createStatusLabel(bool $isActive): string
    {
        if ($isActive) {
            return $this->generateLabel('Active', 'label-info');
        }

        return $this->generateLabel('Inactive', 'label-danger');
    }
}
