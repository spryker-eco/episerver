<?php

namespace SprykerEco\Zed\Optivo;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optivo\OptivoConstants;

class OptivoConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getRequestBaseUrl()
    {
        return rtrim($this->get(OptivoConstants::REQUEST_BASE_URL), '/');
    }

    /**
     * @return int
     */
    public function getRequestTimeout()
    {
        return (int)$this->get(OptivoConstants::REQUEST_TIMEOUT);
    }

    /**
     * @return string
     */
    public function getTokenOperationSubscribe()
    {
        return $this->get(OptivoConstants::TOKEN_OPERATION_SUBSCRIBE);
    }

    /**
     * @return string
     */
    public function getTokenOperationUnsubscribe()
    {
        return $this->get(OptivoConstants::TOKEN_OPERATION_UNSUBSCRIBE);
    }

    /**
     * @return mixed
     */
    public function getTokenOperationSendTransactionEmail()
    {
        return $this->get(OptivoConstants::TOKEN_OPERATION_SEND_TRANSACTION_EMAIL);
    }
}
