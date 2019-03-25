<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapter;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\Http\GuzzleAdapter;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\Http\HttpAdapterInterface;
use SprykerEco\Zed\Episerver\Business\Api\Request\RequestUrlBuilder;
use SprykerEco\Zed\Episerver\Business\Api\Request\RequestUrlBuilderInterface;
use SprykerEco\Zed\Episerver\Business\Api\Response\ResponseConverter;
use SprykerEco\Zed\Episerver\Business\Api\Response\ResponseConverterInterface;
use SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailer;
use SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailerInterface;
use SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailer;
use SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface;
use SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapper;
use SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface;
use SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerNewsletterMapper;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\NewOrderMapper;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderCanceledMapper;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\PaymentNotReceivedMapper;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\ShippingConfirmationMapper;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToMoneyFacadeInterface;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface;
use SprykerEco\Zed\Episerver\EpiserverDependencyProvider;

/**
 * @method \SprykerEco\Zed\Episerver\EpiserverConfig getConfig()
 */
class EpiserverBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface
     */
    public function createShippingConfirmationEventMailer(): OrderEventMailerInterface
    {
        return new OrderEventMailer(
            $this->createShippingConfirmationMapper(),
            $this->createEpiserverApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface
     */
    public function createPaymentNotReceivedEventMailer(): OrderEventMailerInterface
    {
        return new OrderEventMailer(
            $this->createPaymentNotReceivedMapper(),
            $this->createEpiserverApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface
     */
    public function createOrderCancelledEventMailer(): OrderEventMailerInterface
    {
        return new OrderEventMailer(
            $this->createOrderCancelledMapper(),
            $this->createEpiserverApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface
     */
    public function createNewOrderEventMailer(): OrderEventMailerInterface
    {
        return new OrderEventMailer(
            $this->createNewOrderMapper(),
            $this->createEpiserverApiAdapter(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailerInterface
     */
    public function createCustomerEventMailer(): CustomerEventMailerInterface
    {
        return new CustomerEventMailer($this->createCustomerMapper(), $this->createEpiserverApiAdapter());
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailerInterface
     */
    public function createNewsletterSubscriptionEventMailer(): CustomerEventMailerInterface
    {
        return new CustomerEventMailer($this->createCustomerNewsletterMapper(), $this->createEpiserverApiAdapter());
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToMoneyFacadeInterface
     */
    public function getMoneyFacade(): EpiserverToMoneyFacadeInterface
    {
        return $this->getProvidedDependency(EpiserverDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface
     */
    public function getLocaleFacade(): EpiserverToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(EpiserverDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface
     */
    public function getSalesFacade(): EpiserverToSalesFacadeInterface
    {
        return $this->getProvidedDependency(EpiserverDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Api\Request\RequestUrlBuilderInterface
     */
    public function createRequestUrlBuilder(): RequestUrlBuilderInterface
    {
        return new RequestUrlBuilder($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Api\Response\ResponseConverterInterface
     */
    public function createResponseConverter(): ResponseConverterInterface
    {
        return new ResponseConverter();
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Api\Adapter\Http\HttpAdapterInterface
     */
    public function createGuzzleAdapter(): HttpAdapterInterface
    {
        return new GuzzleAdapter(
            $this->getConfig(),
            $this->createHttpClient()
        );
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function createHttpClient(): Client
    {
        return new Client([
            RequestOptions::TIMEOUT => $this->getConfig()->getRequestTimeout(),
        ]);
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface
     */
    public function createEpiserverApiAdapter(): EpiserverApiAdapterInterface
    {
        return new EpiserverApiAdapter(
            $this->createGuzzleAdapter(),
            $this->createRequestUrlBuilder(),
            $this->createResponseConverter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper(
            $this->getConfig(),
            $this->getLocaleFacade(),
            $this->getStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface
     */
    public function createCustomerNewsletterMapper(): CustomerMapperInterface
    {
        return new CustomerNewsletterMapper(
            $this->getConfig(),
            $this->getLocaleFacade(),
            $this->getStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    public function createNewOrderMapper(): OrderMapperInterface
    {
        return new NewOrderMapper(
            $this->getConfig(),
            $this->getMoneyFacade(),
            $this->getLocaleFacade(),
            $this->getStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    public function createPaymentNotReceivedMapper(): OrderMapperInterface
    {
        return new PaymentNotReceivedMapper(
            $this->getConfig(),
            $this->getMoneyFacade(),
            $this->getLocaleFacade(),
            $this->getStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    public function createShippingConfirmationMapper(): OrderMapperInterface
    {
        return new ShippingConfirmationMapper(
            $this->getConfig(),
            $this->getMoneyFacade(),
            $this->getLocaleFacade(),
            $this->getStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    public function createOrderCancelledMapper(): OrderMapperInterface
    {
        return new OrderCanceledMapper(
            $this->getConfig(),
            $this->getMoneyFacade(),
            $this->getLocaleFacade(),
            $this->getStore()
        );
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(EpiserverDependencyProvider::STORE);
    }
}
