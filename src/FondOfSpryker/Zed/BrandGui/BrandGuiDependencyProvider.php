<?php

namespace FondOfSpryker\Zed\BrandGui;

use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToBrandFacadeBridge;
use FondOfSpryker\Zed\BrandGui\Dependency\Facade\BrandGuiToCustomerFacadeBridge;
use Orm\Zed\Brand\Persistence\FosBrandQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class BrandGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_BRAND = 'FACADE_BRAND';
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';

    public const PROPEL_QUERY_FOS_BRAND = 'PROPEL_QUERY_FOS_BRAND';
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addBrandFacade($container);
        $container = $this->addCustomerFacade($container);
        $container = $this->addBrandPropelQuery($container);
        $container = $this->addCustomerPropelQuery($container);

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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = function () {
            return SpyCustomerQuery::create();
        };

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
    protected function addCustomerFacade(Container $container): Container
    {
        $container[static::FACADE_CUSTOMER] = function (Container $container) {
            return new BrandGuiToCustomerFacadeBridge($container->getLocator()->customer()->facade());
        };

        return $container;
    }
}
