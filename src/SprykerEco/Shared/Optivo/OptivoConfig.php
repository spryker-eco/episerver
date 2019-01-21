<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Optivo;

class OptivoConfig
{
    public const SERVICE_FORM_TYPE = 'http/form';
    public const OPERATION_SEND_TRANSACTION_EMAIL = 'sendtransactionmail';
    public const OPERATION_SUBSCRIBE_EVENT_EMAIL = 'subscribe';
    public const OPERATION_UNSUBSCRIBE_EVENT_EMAIL = 'unsubscribe';
    public const OPERATION_UPDATE_FIELDS_EVENT_EMAIL = 'updatefields';

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
    public function getServiceFormType(): string
    {
        return static::SERVICE_FORM_TYPE;
    }

    /**
     * @return string
     */
    public function getOperationTypeSubscribeEventEmail(): string
    {
        return static::OPERATION_SUBSCRIBE_EVENT_EMAIL;
    }

    /**
     * @return string
     */
    public function getOperationTypeUnsubscribeEventEmail(): string
    {
        return static::OPERATION_UNSUBSCRIBE_EVENT_EMAIL;
    }

    /**
     * @return string
     */
    public function getOperationTypeUpdateFieldsEventEmail(): string
    {
        return static::OPERATION_UPDATE_FIELDS_EVENT_EMAIL;
    }
}
