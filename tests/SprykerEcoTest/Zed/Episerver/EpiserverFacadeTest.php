<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Episerver;

use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\AddressTransfer;
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
use SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventHandlerInterface;
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
            $facade->handleCustomerEvent($this->prepareMailTransfer());
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
            $facade->handleNewsletterSubscription($this->prepareMailTransfer());
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
            $facade->handleShippingConfirmationEvent(1);
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
            $facade->handlePaymentNotReceivedEvent(1);
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
            $facade->handleOrderCanceledEvent(1);
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
            $facade->handleNewOrderEvent(1);
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
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Business\EpiserverBusinessFactory
     */
    protected function createEpiserverFactoryMock(): EpiserverBusinessFactory
    {
        $factory = $this->getMockBuilder(EpiserverBusinessFactory::class)
            ->setMethods([
                'createShippingConfirmationEventHandler',
                'createPaymentNotReceivedEventHandler',
                'createOrderCancelledEventHandler',
                'createNewOrderEventHandler',
                'createCustomerEventHandler',
                'createNewsletterSubscriptionEventHandler',
            ])
            ->getMock();

        $factory->method('createNewOrderEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createOrderCancelledEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createPaymentNotReceivedEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createShippingConfirmationEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createCustomerEventHandler')->willReturn($this->createCustomerEventHandlerMock());
        $factory->method('createNewsletterSubscriptionEventHandler')->willReturn($this->createCustomerEventHandlerMock());

        return $factory;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Business\Handler\Order\OrderEventHandlerInterface
     */
    protected function createOrderEventHandlerMock(): OrderEventHandlerInterface
    {
        $handler = $this->getMockBuilder(OrderEventHandlerInterface::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createOrderMapperMock(), $this->createAdapterMock(), $this->createSalesFacadeMock()])
            ->enableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();

        $handler->method('handle')->willReturn($this->createStreamInterfaceMock());

        return $handler;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createOrderMapperMock(): OrderMapperInterface
    {
        $mapper = $this->getMockBuilder(OrderMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['mapOrderTransferToEpiserverRequestTransfer'])
            ->getMock();

        $mapper->method('mapOrderTransferToEpiserverRequestTransfer')->willReturn(new EpiserverRequestTransfer());

        return $mapper;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface
     */
    protected function createAdapterMock(): EpiserverApiAdapterInterface
    {
        return $this->getMockBuilder(EpiserverApiAdapterInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface
     */
    protected function createSalesFacadeMock(): EpiserverToSalesFacadeInterface
    {
        $facade = $this->getMockBuilder(EpiserverToSalesFacadeInterface::class)
            ->setMethods(['getOrderByIdSalesOrder'])
            ->getMock();

        $facade->method('getOrderByIdSalesOrder')->willReturn(new OrderTransfer());

        return $facade;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Psr\Http\Message\StreamInterface
     */
    protected function createStreamInterfaceMock(): StreamInterface
    {
        return $this->getMockBuilder(StreamInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    protected function createCustomerEventHandlerMock(): CustomerEventHandlerInterface
    {
        $handler = $this->getMockBuilder(CustomerEventHandlerInterface::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createCustomerMapperMock(), $this->createAdapterMock()])
            ->enableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();

        $handler->method('handle')->willReturn($this->createStreamInterfaceMock());

        return $handler;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected function createCustomerMapperMock(): CustomerMapperInterface
    {
        $mapper = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['mapCustomerEntityToCustomer', 'mapCustomerAddressEntityToTransfer'])
            ->getMock();

        $mapper->method('mapCustomerEntityToCustomer')->willReturn(new CustomerTransfer());
        $mapper->method('mapCustomerAddressEntityToTransfer')->willReturn(new AddressTransfer());

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
