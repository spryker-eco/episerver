<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Order;

class NewOrderMapper extends AbstractOrderMapper
{
    /**
     * @return string
     */
    protected function getMailingId(): string
    {
        return $this->config->getOrderNewMailingId();
    }
}
