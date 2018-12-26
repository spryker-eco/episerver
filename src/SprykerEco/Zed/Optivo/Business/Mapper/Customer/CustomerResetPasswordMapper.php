<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

class CustomerResetPasswordMapper extends AbstractCustomerMapper
{
    /**
     * @return string
     */
    protected function getMailingId(): string
    {
        return $this->config->getCustomerResetPasswordMailingId();
    }
}
