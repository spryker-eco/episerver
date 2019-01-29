<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Handler\Order;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToSalesFacadeInterface;

class OrderEventMailer implements OrderEventMailerInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Business\Mapper\Order\OrderMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface
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
    public function mail(int $idSalesOrder): void
    {
        $requestTransfer = new OptivoRequestTransfer();
        $orderTransfer = $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
        $requestTransfer = $this->mapOrderTransferToOptivoRequestTransfer($orderTransfer, $requestTransfer);
        $this->send($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    protected function mapOrderTransferToOptivoRequestTransfer(OrderTransfer $orderTransfer, OptivoRequestTransfer $requestTransfer): OptivoRequestTransfer
    {
        return $this->mapper->mapOrderTransferToOptivoRequestTransfer($orderTransfer, $requestTransfer);
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
