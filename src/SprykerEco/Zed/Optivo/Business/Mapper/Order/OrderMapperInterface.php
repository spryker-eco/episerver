<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Order;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface OrderMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(OrderTransfer $transfer): OptivoRequestTransfer;
}
