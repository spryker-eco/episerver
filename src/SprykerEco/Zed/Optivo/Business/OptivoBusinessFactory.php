<?php

namespace SprykerEco\Zed\Optivo\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\Guzzle;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapter;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\Http\HttpAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\OptivoApi;
use SprykerEco\Zed\Optivo\Business\Api\OptivoApiInterface;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilder;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverter;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSender;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSenderInterface;
use SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface;
use SprykerEco\Zed\Optivo\OptivoDependencyProvider;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoQueryContainer getQueryContainer()
 */
class OptivoBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return OptivoMailSenderInterface
     */
    public function createOptivoMailSender()
    {
        return new OptivoMailSender(
            $this->getRequestPluginsMap()
        );
    }

    /**
     * @return OptivoRequestPluginInterface[]
     */
    protected function getRequestPluginsMap()
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::OPERATION_PLUGINS_MAP);
    }

    /**
     * @return OptivoApiInterface
     */
    public function createOptivoApi()
    {
        return new OptivoApi(
            $this->createOptivoApiAdapter(),
            $this->getConfig()
        );
    }

    /**
     * @return OptivoApiAdapterInterface
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
     * @return HttpAdapterInterface
     */
    protected function createGuzzle()
    {
        return new Guzzle($this->getConfig());
    }

    /**
     * @return RequestUrlBuilderInterface
     */
    protected function createRequestUrlBuilder()
    {
        return new RequestUrlBuilder(
            $this->getConfig()
        );
    }

    /**
     * @return ResponseConverterInterface
     */
    protected function createResponseConverter()
    {
        return new ResponseConverter();
    }
}
