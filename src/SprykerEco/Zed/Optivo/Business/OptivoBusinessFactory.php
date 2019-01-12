<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\Guzzle;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapter;
use SprykerEco\Zed\Optivo\Business\Api\OptivoApi;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilder;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverter;
use SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandler;
use SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandler;
use SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\NewOrderMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderCanceledMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\PaymentNotReceivedMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\ShippingConfirmationMapper;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSender;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoDependencyProvider;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoEntityManagerInterface getEntityManager()≈
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoRepositoryInterface getRepository()
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
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createNewOrderEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createNewOrderMapper(),
            $this->createOptivoApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createOrderCancelledEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createOrderCancelledMapper(),
            $this->createOptivoApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createPaymentNotReceivedEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createPaymentNotReceivedMapper(),
            $this->createOptivoApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface
     */
    public function createShippingConfirmationEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createShippingConfirmationMapper(),
            $this->createOptivoApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    public function createCustomerEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler(
            $this->createCustomerMapper(),
            $this->createOptivoApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createNewOrderMapper(): OrderMapperInterface
    {
        return new NewOrderMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createOrderCancelledMapper(): OrderMapperInterface
    {
        return new OrderCanceledMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createPaymentNotReceivedMapper(): OrderMapperInterface
    {
        return new PaymentNotReceivedMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createShippingConfirmationMapper(): OrderMapperInterface
    {
        return new ShippingConfirmationMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper($this->getConfig(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface
     */
    protected function getLocaleFacade(): OptivoToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface
     */
    protected function getMoneyFacade(): OptivoToMoneyFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface
     */
    protected function getSalesFacade(): OptivoToSalesFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_SALES);
    }
}
