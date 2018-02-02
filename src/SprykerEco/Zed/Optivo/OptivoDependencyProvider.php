<?php

namespace SprykerEco\Zed\Optivo;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Optivo\Communication\Plugin\MailOperation\OptivoSubscribeRequestPlugin;
use SprykerEco\Zed\Optivo\Communication\Plugin\MailOperation\OptivoTransactionalMailRequestPlugin;
use SprykerEco\Zed\Optivo\Communication\Plugin\MailOperation\OptivoUnsubscribeRequestPlugin;

class OptivoDependencyProvider extends AbstractBundleDependencyProvider
{

    const OPERATION_PLUGINS_MAP = 'OPERATION_PLUGINS_MAP';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        //TODO Provide dependencies

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[self::OPERATION_PLUGINS_MAP] = function(Container $container) {
            return [
                OptivoSubscribeRequestTransfer::class => new OptivoSubscribeRequestPlugin(),
                OptivoUnsubscribeRequestTransfer::class => new OptivoUnsubscribeRequestPlugin(),
                OptivoTransactionalMailRequestTransfer::class => new OptivoTransactionalMailRequestPlugin(),
            ];
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        //TODO Provide dependencies

        return $container;
    }

}
