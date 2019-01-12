<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Handler\Order;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface;

class OrderEventHandler implements OrderEventHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface $mapper
     * @param \SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface $adapter
     * @param \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface $salesFacade
     */
    public function __construct(OrderMapperInterface $mapper, OptivoApiAdapterInterface $adapter, OptivoToSalesFacadeInterface $salesFacade)
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
    public function handle(int $idSalesOrder): void
    {
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $requestTransfer = $this->map($orderTransfer);
        $this->send($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    protected function map(OrderTransfer $orderTransfer): OptivoRequestTransfer
    {
        return $this->mapper->map($orderTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    protected function send(OptivoRequestTransfer $optivoRequestTransfer): OptivoResponseTransfer
    {
        return $this->adapter->sendRequest($optivoRequestTransfer);
    }
}
