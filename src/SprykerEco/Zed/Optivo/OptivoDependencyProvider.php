<?php

namespace SprykerEco\Zed\Optivo;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeBridge;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeBridge;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeBridge;

class OptivoDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MONEY = 'FACADE_MONEY';
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const FACADE_SALES = 'FACADE_SALES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addFacadeMoney($container);
        $container = $this->addFacadeLocale($container);
        $container = $this->addFacadeSales($container);

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
            return new OptivoToMoneyFacadeBridge($container->getLocator()->money()->facade());
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
            return new OptivoToLocaleFacadeBridge($container->getLocator()->locale()->facade());
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
            return new OptivoToSalesFacadeBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }
}
