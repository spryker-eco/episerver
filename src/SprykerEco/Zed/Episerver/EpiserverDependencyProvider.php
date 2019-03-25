<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeBridge;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToMoneyFacadeBridge;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeBridge;

class EpiserverDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MONEY = 'FACADE_MONEY';
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const FACADE_SALES = 'FACADE_SALES';
    public const STORE = 'STORE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addFacadeMoney($container);
        $container = $this->addFacadeLocale($container);
        $container = $this->addFacadeSales($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeMoney(Container $container): Container
    {
        $container[static::FACADE_MONEY] = function (Container $container) {
            return new EpiserverToMoneyFacadeBridge($container->getLocator()->money()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeLocale(Container $container): Container
    {
        $container[static::FACADE_LOCALE] = function (Container $container) {
            return new EpiserverToLocaleFacadeBridge($container->getLocator()->locale()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeSales(Container $container): Container
    {
        $container[static::FACADE_SALES] = function (Container $container) {
            return new EpiserverToSalesFacadeBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };

        return $container;
    }
}
