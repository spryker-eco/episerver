<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
