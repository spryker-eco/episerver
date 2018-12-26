<?php

namespace SprykerEco\Shared\Optivo;

class OptivoConfig
{
    public const SERVICE_FORM_TYPE = 'http/form';

    public const OPERATION_SEND_TRANSACTION_EMAIL = 'sendtransactionmail';
    public const OPERATION_SEND_EVENT_EMAIL = 'sendeventmail';

    /**
     * @return string
     */
    public function getOperationTypeSendTransactionEmail(): string
    {
        return static::OPERATION_SEND_TRANSACTION_EMAIL;
    }

    /**
     * @return string
     */
    public function getOperationTypeSendEventEmail(): string
    {
        return static::OPERATION_SEND_EVENT_EMAIL;
    }

    /**
     * @return string
     */
    public function getServiceFormType(): string
    {
        return static::SERVICE_FORM_TYPE;
    }
}
