<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface OptivoToSalesFacadeInterface
{
    /**
     * @param int $idOrder
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderByIdSalesOrder(int $idOrder): OrderTransfer;
}
