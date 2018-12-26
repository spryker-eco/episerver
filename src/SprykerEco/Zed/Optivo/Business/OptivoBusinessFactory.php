<?php

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
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerRegistrationMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerResetPasswordMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\NewOrderMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderCanceledMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\PaymentNotReceivedMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\ShippingConfirmationMapper;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSender;
use SprykerEco\Zed\Optivo\Business\Strategy\OptivoRequestHandler;
use SprykerEco\Zed\Optivo\Business\Strategy\OptivoRequestHandlerInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoDependencyProvider;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoEntityManagerInterface getEntityManager()≈
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
     * @return OrderEventHandlerInterface
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
     * @return OrderEventHandlerInterface
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
     * @return OrderEventHandlerInterface
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
     * @return OrderEventHandlerInterface
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
    public function createCustomerRegistrationEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler(
            $this->createCustomerRegistrationMapper(),
            $this->createOptivoApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    public function createCustomerResetPasswordEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler(
            $this->createCustomerResetPasswordMapper(),
            $this->createOptivoApiAdapter()
        );
    }

    /**
     * @return OrderMapperInterface
     */
    protected function createNewOrderMapper(): OrderMapperInterface
    {
        return new NewOrderMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return OrderMapperInterface
     */
    protected function createOrderCancelledMapper(): OrderMapperInterface
    {
        return new OrderCanceledMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return OrderMapperInterface
     */
    protected function createPaymentNotReceivedMapper(): OrderMapperInterface
    {
        return new PaymentNotReceivedMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return OrderMapperInterface
     */
    protected function createShippingConfirmationMapper(): OrderMapperInterface
    {
        return new ShippingConfirmationMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return CustomerMapperInterface
     */
    protected function createCustomerRegistrationMapper(): CustomerMapperInterface
    {
        return new CustomerRegistrationMapper($this->getConfig(), $this->getLocaleFacade());
    }

    /**
     * @return CustomerMapperInterface
     */
    protected function createCustomerResetPasswordMapper(): CustomerMapperInterface
    {
        return new CustomerResetPasswordMapper($this->getConfig(), $this->getLocaleFacade());
    }

    /**
     * @return OptivoToLocaleFacadeInterface
     */
    protected function getLocaleFacade(): OptivoToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return OptivoToMoneyFacadeInterface
     */
    protected function getMoneyFacade(): OptivoToMoneyFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_MONEY);
    }


    /**
     * @return OptivoToSalesFacadeInterface
     */
    protected function getSalesFacade(): OptivoToSalesFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_SALES);
    }
}
