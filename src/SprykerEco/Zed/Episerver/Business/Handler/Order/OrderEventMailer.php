<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Handler\Order;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\EpiserverResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface;
use SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface;

class OrderEventMailer implements OrderEventMailerInterface
{
    /**
     * @var \SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface
     */
    protected $adapter;

    /**
     * @var \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \SprykerEco\Zed\Episerver\Business\Mapper\Order\OrderMapperInterface $mapper
     * @param \SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface $adapter
     * @param \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToSalesFacadeInterface $salesFacade
     */
    public function __construct(OrderMapperInterface $mapper, EpiserverApiAdapterInterface $adapter, EpiserverToSalesFacadeInterface $salesFacade)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mail(int $idSalesOrder): void
    {
        $requestTransfer = new EpiserverRequestTransfer();
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $requestTransfer = $this->mapOrderTransferToEpiserverRequestTransfer($orderTransfer, $requestTransfer);
        $this->send($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverRequestTransfer
     */
    protected function mapOrderTransferToEpiserverRequestTransfer(OrderTransfer $orderTransfer, EpiserverRequestTransfer $requestTransfer): EpiserverRequestTransfer
    {
        return $this->mapper->mapOrderTransferToEpiserverRequestTransfer($orderTransfer, $requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $episerverRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverResponseTransfer
     */
    protected function send(EpiserverRequestTransfer $episerverRequestTransfer): EpiserverResponseTransfer
    {
        return $this->adapter->sendRequest($episerverRequestTransfer);
    }
}
