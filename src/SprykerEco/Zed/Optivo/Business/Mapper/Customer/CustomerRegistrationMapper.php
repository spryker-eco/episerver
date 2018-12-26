<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

class CustomerRegistrationMapper extends AbstractCustomerMapper
{
    /**
     * @return string
     */
    protected function getMailingId(): string
    {
        return $this->config->getCustomerRegistrationMailingId();
    }
}
