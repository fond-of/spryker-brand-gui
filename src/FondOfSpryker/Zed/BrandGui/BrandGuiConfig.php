<?php

namespace FondOfSpryker\Zed\BrandGui;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class BrandGuiConfig extends AbstractBundleConfig
{
    protected const REDIRECT_URL_DEFAULT = '/brand-gui';

    /**
     * @return string
     */
    public function getDefaultRedirectUrl(): string
    {
        return static::REDIRECT_URL_DEFAULT;
    }
}
