<?php

namespace SprykerEco\Zed\Optivo\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\Guzzle;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapter;
use SprykerEco\Zed\Optivo\Business\Api\OptivoApi;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilder;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverter;
use SprykerEco\Zed\Optivo\Business\Strategy\OptivoStrategyInterface;
use SprykerEco\Zed\Optivo\Business\Strategy\OptivoSubscribeNewsletterStrategy;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSender;
use SprykerEco\Zed\Optivo\OptivoDependencyProvider;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoQueryContainerInterface getQueryContainer()
 */
class OptivoBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Optivo\Business\Model\OptivoMailSenderInterface
     */
    public function createOptivoMailSender()
    {
        return new OptivoMailSender(
            $this->getRequestPluginsMap()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface[]
     */
    protected function getRequestPluginsMap()
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::OPERATION_PLUGINS_MAP);
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\OptivoApiInterface
     */
    public function createOptivoApi()
    {
        return new OptivoApi(
            $this->createOptivoApiAdapter(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface
     */
    protected function createOptivoApiAdapter()
    {
        return new OptivoApiAdapter(
            $this->createGuzzle(),
            $this->createRequestUrlBuilder(),
            $this->createResponseConverter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\HttpAdapterInterface
     */
    protected function createGuzzle()
    {
        return new Guzzle($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface
     */
    protected function createRequestUrlBuilder()
    {
        return new RequestUrlBuilder(
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface
     */
    protected function createResponseConverter()
    {
        return new ResponseConverter();
    }

    /**
     * @return OptivoStrategyInterface
     */
    public function createOptivoSubscribeNewsletterStrategy(): OptivoStrategyInterface
    {
        return new OptivoSubscribeNewsletterStrategy($this->createOptivoApi());
    }
}
