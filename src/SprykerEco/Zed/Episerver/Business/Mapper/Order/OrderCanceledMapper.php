<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Mapper\Order;

class OrderCanceledMapper extends AbstractOrderMapper
{
    /**
     * @return string
     */
    protected function getMailingId(): string
    {
        return $this->config->getOrderCancelledMailingId();
    }
}
