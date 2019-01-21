<?php
/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Optivo;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Optivo\Business\Handler\Order\OrderEventHandlerInterface;
use SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory;

use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
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
//    /**
//     * @return void
//     */
//    public function testHandleCustomerRegisterEvent()
//    {
//        $facade = $this->prepareFacade();
//        $this->assertEmpty($facade->handleCustomerRegistrationEvent($this->prepareCustomerTransfer()));
//    }
//    /**
//     * @return void
//     */
//    public function testHandleCustomerResetPasswordEvent()
//    {
//        $facade = $this->prepareFacade();
//        $this->assertEmpty($facade->handleCustomerResetPasswordEvent($this->prepareCustomerTransfer()));
//    }
//    /**
//     * @return void
//     */

//    /**
//     * @return void
//     */
//    public function testHandleOrderCanceledEvent()
//    {
//        $facade = $this->prepareFacade();
//        $this->assertEmpty($facade->handleOrderCanceledEvent(1));
//    }
//    /**
//     * @return void
//     */
//    public function testHandleShippingConfirmationEvent()
//    {
//        $facade = $this->prepareFacade();
//        $this->assertEmpty($facade->handleShippingConfirmationEvent(1));
//    }
//    /**
//     * @return void
//     */
//    public function testHandlePaymentNotReceivedEvent()
//    {
//        $facade = $this->prepareFacade();
//        $this->assertEmpty($facade->handlePaymentNotReceivedEvent(1));
//    }


    public function testHandleOrderCreatedEvent(): void
    {
        $facade = $this->prepareFacade();

        $this->assertEmpty($facade->handleNewOrderEvent(1));
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

//                'createCustomerEventHandler',
//                'createNewsletterSubscriptionEventHandler',
            ])
            ->getMock();




        $factory->method('createNewOrderEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createOrderCancelledEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createPaymentNotReceivedEventHandler')->willReturn($this->createOrderEventHandlerMock());
        $factory->method('createShippingConfirmationEventHandler')->willReturn($this->createOrderEventHandlerMock());

//        $factory->method('createCustomerRegistrationEventHandler')->willReturn($this->createCustomerEventHandlerMock());
//        $factory->method('createCustomerResetPasswordEventHandler')->willReturn($this->createCustomerEventHandlerMock());


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
            ->setMethods(['send'])
            ->getMock();

        $handler->method('send')->willReturn($this->createStreamInterfaceMock());

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
     * @return \SprykerEco\Zed\Inxmail\Business\Handler\Customer\CustomerEventHandlerInterface
     */
    protected function createCustomerEventHandlerMock(): CustomerEventHandlerInterface
    {
        $handler = $this->getMockBuilder(CustomerEventHandler::class)
            ->disableOriginalConstructor()
            ->setConstructorArgs([$this->createCustomerMapperMock(), $this->createAdapterMock()])
            ->enableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();
        $handler->method('send')->willReturn($this->createStreamInterfaceMock());

        return $handler;
    }

    /**
     * @return \SprykerEco\Zed\Inxmail\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected function createCustomerMapperMock(): CustomerMapperInterface
    {
        $mapper = $this->getMockBuilder(CustomerMapperInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['map'])
            ->getMock();

        $mapper->method('map')->willReturn(new InxmailRequestTransfer());

        return $mapper;
    }




    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function prepareCustomerTransfer(): CustomerTransfer
    {
        return new CustomerTransfer();
    }



    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function createStreamInterfaceMock(): StreamInterface
    {
        $stream = $this->getMockBuilder(StreamInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $stream;
    }

}