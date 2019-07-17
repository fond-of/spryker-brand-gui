<?php

namespace FondOfSpryker\Zed\BrandGui;

use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeBridge;
use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class BrandGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_BRAND = 'FACADE_BRAND';

    public const PROPEL_QUERY_FOS_BRAND = 'PROPEL_QUERY_FOS_BRAND';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addBrandFacade($container);
        $container = $this->addBrandPropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addBrandFacade(Container $container): Container
    {
        $container[static::FACADE_BRAND] = function (Container $container) {
            return new BrandGuiToBrandFacadeBridge($container->getLocator()->brand()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addBrandPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_FOS_BRAND] = function () {
            return FosBrandQuery::create();
        };
        return $container;
    }
}
