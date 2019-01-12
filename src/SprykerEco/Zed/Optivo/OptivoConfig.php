<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Optivo\OptivoConstants;

/**
 * @method \SprykerEco\Shared\Optivo\OptivoConfig getSharedConfig()
 */
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
    public function getOrderListAuthCode(): string
    {
        return $this->get(OptivoConstants::ORDER_LIST_AUTHORIZATION_CODE);
    }

    public function getCustomerListAuthCode(): string
    {
        return $this->get(OptivoConstants::CUSTOMER_LIST_AUTHORIZATION_CODE);
    }

    /**
     * @return string
     */
    public function getOrderNewMailingId(): string
    {
        return $this->get(OptivoConstants::ORDER_NEW_MAILING_ID);
    }

    /**
     * @return string
     */
    public function getOrderPaymentIsNotReceivedMailingId(): string
    {
        return $this->get(OptivoConstants::ORDER_PAYMENT_IS_NOT_RECEIVED_MAILING_ID);
    }

    /**
     * @return string
     */
    public function getOrderShippingConfirmationMailingId(): string
    {
        return $this->get(OptivoConstants::ORDER_SHIPPING_CONFIRMATION_MAILING_ID);
    }

    /**
     * @return string
     */
    public function getOrderCancelledMailingId(): string
    {
        return $this->get(OptivoConstants::ORDER_CANCELLED_MAILING_ID);
    }

    /**
     * @return string
     */
    public function getOperationTypeSendTransactionEmail(): string
    {
        return $this->getSharedConfig()->getOperationTypeSendTransactionEmail();
    }

    /**
     * @return string
     */
    public function getOperationTypeSendEventEmailEmail(): string
    {
        return $this->getSharedConfig()->getOperationTypeSendEventEmail();
    }

    /**
     * @return string
     */
    public function getServiceFormType(): string
    {
        return $this->getSharedConfig()->getServiceFormType();
    }

    /**
     * @return string
     */
    public function getHostYves(): string
    {
        return $this->get(ApplicationConstants::HOST_YVES);
    }

    /**
     * @param string $mailingTypeName
     *
     * @return string
     */
    public function getMailingIdByMailingTypeName(string $mailingTypeName): string
    {
        return $this->get(OptivoConstants::OPTIVO_CONFIGURATION_MAILING_ID_LIST)[$mailingTypeName];
    }
}
