<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Episerver;

class EpiserverConfig
{
    protected const SERVICE_FORM_TYPE = 'http/form';
    protected const OPERATION_SEND_TRANSACTION_EMAIL = 'sendtransactionmail';
    protected const OPERATION_SUBSCRIBE_EVENT_EMAIL = 'subscribe';
    protected const OPERATION_UNSUBSCRIBE_EVENT_EMAIL = 'unsubscribe';
    protected const OPERATION_UPDATE_FIELDS_EVENT_EMAIL = 'updatefields';

    /**
     * @return string
     */
    public function getOperationSendTransactionEmail(): string
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
    public function getOperationSubscribeEventEmail(): string
    {
        return static::OPERATION_SUBSCRIBE_EVENT_EMAIL;
    }

    /**
     * @return string
     */
    public function getOperationUnsubscribeEventEmail(): string
    {
        return static::OPERATION_UNSUBSCRIBE_EVENT_EMAIL;
    }

    /**
     * @return string
     */
    public function getOperationUpdateFieldsEventEmail(): string
    {
        return static::OPERATION_UPDATE_FIELDS_EVENT_EMAIL;
    }
}
