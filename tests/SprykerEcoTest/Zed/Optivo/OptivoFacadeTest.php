<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Optivo;

use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Zed\Customer\Persistence\Mapper\CustomerMapperInterface;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory;
use SprykerEco\Zed\Optivo\Business\OptivoFacade;
use SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Optivo
 * @group OptivoFacadeTest
 */
class OptivoFacadeTest extends Unit
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
     * @return \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface
     */
    protected function prepareFacade(): OptivoFacadeInterface
    {
        $facade = $this->createOptivolFacade();
        $facade->setFactory($this->createOptivoFactoryMock());

        return $facade;
    }

    /**
     * @return \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface
     */
    protected function createOptivolFacade(): OptivoFacadeInterface
    {
        return new OptivoFacade();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory
     */
    protected function createOptivoFactoryMock(): OptivoBusinessFactory
    {
        $factory = $this->getMockBuilder(OptivoBusinessFactory::class)
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
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface
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
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected function createOrderMapperMock(): OrderMapperInterface
    {
        $mapper = $this->getMockBuilder(OrderMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['map'])
            ->getMock();

        $mapper->method('map')->willReturn(new OptivoRequestTransfer());

        return $mapper;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface
     */
    protected function createAdapterMock(): OptivoApiAdapterInterface
    {
        return $this->getMockBuilder(OptivoApiAdapterInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface
     */
    protected function createSalesFacadeMock(): OptivoToSalesFacadeInterface
    {
        $facade = $this->getMockBuilder(OptivoToSalesFacadeInterface::class)
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
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Business\Handler\Customer\CustomerEventHandlerInterface
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
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface
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
