<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Handler\Order;

interface OrderEventMailerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mail(int $idSalesOrder): void;
}
