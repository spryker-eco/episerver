<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Episerver;

use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Zed\Customer\Persistence\Mapper\CustomerMapperInterface;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface;
use SprykerEco\Zed\Episerver\Business\EpiserverBusinessFactory;
use SprykerEco\Zed\Episerver\Business\EpiserverFacade;
use SprykerEco\Zed\Episerver\Business\EpiserverFacadeInterface;
use SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailer;
use SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailerInterface;
use SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailer;
use SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Episerver
 * @group EpiserverFacadeTest
 */
class EpiserverFacadeTest extends Unit
{
    /**
     * @return void
     */
    public function testHandleCustomerEvent(): void
    {
        $facade = $this->prepareFacade();

        try {
            $facade->sendCustomerEventMail($this->prepareMailTransfer());
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testNewsletterSubscription(): void
    {
        $facade = $this->prepareFacade();

        try {
            $facade->sendNewsletterSubscriptionMail($this->prepareMailTransfer());
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testHandleShippingConfirmationEvent(): void
    {
        $facade = $this->prepareFacade();

        try {
            $facade->sendShippingConfirmationEventMail(1);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testHandlePaymentNotReceivedEvent(): void
    {
        $facade = $this->prepareFacade();

        try {
            $facade->sendPaymentNotReceivedEventMail(1);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testHandleOrderCanceledEvent(): void
    {
        $facade = $this->prepareFacade();

        try {
            $facade->sendOrderCanceledEventMail(1);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function testHandleOrderCreatedEvent(): void
    {
        $facade = $this->prepareFacade();

        try {
            $facade->sendNewOrderEventMail(1);
        } catch (Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\EpiserverFacadeInterface
     */
    protected function prepareFacade(): EpiserverFacadeInterface
    {
        $facade = $this->createEpiserverlFacade();
        $facade->setFactory($this->createEpiserverFactoryMock());

        return $facade;
    }

    /**
     * @return \SprykerEco\Zed\Episerver\Business\EpiserverFacadeInterface
     */
    protected function createEpiserverlFacade(): EpiserverFacadeInterface
    {
        return new EpiserverFacade();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Business\EpiserverBusinessFactory
     */
    protected function createEpiserverFactoryMock()
    {
        $factory = $this->getMockBuilder(EpiserverBusinessFactory::class)
            ->setMethods([
                'createShippingConfirmationEventMailer',
                'createPaymentNotReceivedEventMailer',
                'createOrderCancelledEventMailer',
                'createNewOrderEventMailer',
                'createCustomerEventMailer',
                'createNewsletterSubscriptionEventMailer',
            ])
            ->getMock();

        $factory->method('createNewOrderEventMailer')->willReturn($this->createOrderEventMailerMock());
        $factory->method('createOrderCancelledEventMailer')->willReturn($this->createOrderEventMailerMock());
        $factory->method('createPaymentNotReceivedEventMailer')->willReturn($this->createOrderEventMailerMock());
        $factory->method('createShippingConfirmationEventMailer')->willReturn($this->createOrderEventMailerMock());
        $factory->method('createCustomerEventMailer')->willReturn($this->createCustomerEventMailerMock());
        $factory->method('createNewsletterSubscriptionEventMailer')->willReturn($this->createCustomerEventMailerMock());

        return $factory;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventMailerInterface
     */
    protected function createOrderEventMailerMock()
    {
        $handler = $this->getMockBuilder(OrderEventMailer::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createOrderMapperMock(), $this->createAdapterMock(), $this->createSalesFacadeMock()])
            ->setMethods(['mail'])
            ->getMock();

        return $handler;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createOrderMapperMock()
    {
        $mapper = $this->getMockBuilder(OrderMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['mapOrderTransferToEpiserverRequestTransfer'])
            ->getMock();

        $mapper->method('mapOrderTransferToEpiserverRequestTransfer')->willReturn(new EpiserverRequestTransfer());

        return $mapper;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface
     */
    protected function createAdapterMock()
    {
        return $this->getMockBuilder(EpiserverApiAdapterInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept()
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface
     */
    protected function createSalesFacadeMock()
    {
        $facade = $this->getMockBuilder(EpiserverToSalesFacadeInterface::class)
            ->setMethods(['getOrderByIdSalesOrder'])
            ->getMock();

        $facade->method('getOrderByIdSalesOrder')->willReturn(new OrderTransfer());

        return $facade;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventMailerInterface
     */
    protected function createCustomerEventMailerMock()
    {
        $handler = $this->getMockBuilder(CustomerEventMailer::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createCustomerMapperMock(), $this->createAdapterMock()])
            ->setMethods(['mail'])
            ->getMock();

        return $handler;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected function createCustomerMapperMock()
    {
        $mapper = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'mapCustomerEntityToCustomer',
                'mapCustomerAddressEntityToTransfer',
                'mapCustomerAddressEntityToAddressTransfer',
                'mapCountryEntityToCountryTransfer'
            ])
            ->getMock();

        $mapper->method('mapCustomerEntityToCustomer')->willReturn(new CustomerTransfer());
        $mapper->method('mapCustomerAddressEntityToTransfer')->willReturn(new AddressTransfer());
        $mapper->method('mapCustomerAddressEntityToAddressTransfer')->willReturn(new AddressTransfer());
        $mapper->method('mapCountryEntityToCountryTransfer')->willReturn(new CountryTransfer());

        return $mapper;
    }

    /**
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    protected function prepareMailTransfer(): MailTransfer
    {
        return new MailTransfer();
    }
}
