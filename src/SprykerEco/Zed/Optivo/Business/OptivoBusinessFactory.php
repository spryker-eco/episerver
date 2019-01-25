<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\GuzzleAdapter;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\HttpAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapter;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilder;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverter;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface;
use SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandler;
use SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandler;
use SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerNewsletterMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\NewOrderMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderCanceledMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\PaymentNotReceivedMapper;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\ShippingConfirmationMapper;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoDependencyProvider;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 */
class OptivoBusinessFactory extends AbstractBusinessFactory
{
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
    public function createNewOrderEventHandler(): OrderEventHandlerInterface
    {
        return new OrderEventHandler(
            $this->createNewOrderMapper(),
            $this->createOptivoApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    public function createCustomerEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler($this->createCustomerMapper(), $this->createOptivoApiAdapter());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    public function createNewsletterSubscriptionEventHandler(): CustomerEventHandlerInterface
    {
        return new CustomerEventHandler($this->createCustomerNewsletterMapper(), $this->createOptivoApiAdapter());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface
     */
    public function getMoneyFacade(): OptivoToMoneyFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface
     */
    public function getLocaleFacade(): OptivoToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface
     */
    public function getSalesFacade(): OptivoToSalesFacadeInterface
    {
        return $this->getProvidedDependency(OptivoDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface
     */
    public function createRequestUrlBuilder(): RequestUrlBuilderInterface
    {
        return new RequestUrlBuilder($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface
     */
    public function createResponseConverter(): ResponseConverterInterface
    {
        return new ResponseConverter();
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\HttpAdapterInterface
     */
    public function createGuzzleAdapter(): HttpAdapterInterface
    {
        return new GuzzleAdapter($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface
     */
    public function createOptivoApiAdapter(): OptivoApiAdapterInterface
    {
        return new OptivoApiAdapter(
            $this->createGuzzleAdapter(),
            $this->createRequestUrlBuilder(),
            $this->createResponseConverter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper($this->getConfig(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerNewsletterMapper(): CustomerMapperInterface
    {
        return new CustomerNewsletterMapper($this->getConfig(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    public function createNewOrderMapper(): OrderMapperInterface
    {
        return new NewOrderMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    public function createPaymentNotReceivedMapper(): OrderMapperInterface
    {
        return new PaymentNotReceivedMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    public function createShippingConfirmationMapper(): OrderMapperInterface
    {
        return new ShippingConfirmationMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    public function createOrderCancelledMapper(): OrderMapperInterface
    {
        return new OrderCanceledMapper($this->getConfig(), $this->getMoneyFacade(), $this->getLocaleFacade());
    }
}
