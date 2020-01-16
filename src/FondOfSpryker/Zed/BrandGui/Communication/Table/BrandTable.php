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
    public const ACTIONS = 'Actions';
    public const URL_PARAMETER_ID_BRAND = 'id-brand';
    public const URL_BRAND_EDIT = RoutingConstants::URL_EDIT;
    public const URL_BRAND_DELETE = RoutingConstants::URL_DELETE;

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

        foreach ($queryResults as $item) {
            $results[] = [
                FosBrandTableMap::COL_ID_BRAND => $item[FosBrandTableMap::COL_ID_BRAND],
                FosBrandTableMap::COL_NAME => $item[FosBrandTableMap::COL_NAME],
                FosBrandTableMap::COL_URL => $item[FosBrandTableMap::COL_URL],
                FosBrandTableMap::COL_IS_ACTIVE => $this->createStatusLabel($item[FosBrandTableMap::COL_URL]),
                self::ACTIONS => implode(' ', $this->buildLinks($item)),
            ];
        }

        return $results;
    }

    /**
     * @param array $queryResult
     *
     * @return array
     */
    protected function buildLinks(array $item): array
    {
        $buttons = [];

        $editUrl = Url::generate(
            static::URL_BRAND_EDIT,
            [
                BrandAbstractController::URL_PARAM_ID_BRAND => $item[FosBrandTableMap::COL_ID_BRAND],
            ]
        );
        $deleteUrl = Url::generate(
            static::URL_BRAND_DELETE,
            [
                BrandAbstractController::URL_PARAM_ID_BRAND => $item[FosBrandTableMap::COL_ID_BRAND],
            ]
        );

        $buttons[] = $this->generateEditButton($editUrl, 'Edit Brand');
        $buttons[] = $this->generateRemoveButton($deleteUrl, 'Remove Brand');

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
