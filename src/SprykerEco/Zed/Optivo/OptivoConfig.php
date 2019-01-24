<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @param string|null $mailingTypeName
     *
     * @return string|null
     */
    public function getMailingIdByMailingTypeName(?string $mailingTypeName): ?string
    {
        if ($mailingTypeName === null) {
            return null;
        }

        $mailingIdList = $this->get(OptivoConstants::CONFIGURATION_DEFAULT_MAILING_ID_LIST);

        if (!empty($mailingIdList[$mailingTypeName])) {
            return $mailingIdList[$mailingTypeName];
        }

        return null;
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
    public function getCustomerListAuthCode(): string
    {
        return $this->get(OptivoConstants::CUSTOMER_LIST_AUTHORIZATION_CODE);
    }

    /**
     * @return string
     */
    public function getCustomerNewsLetterListAuthCode(): string
    {
        return $this->get(OptivoConstants::CUSTOMER_NEWSLETTER_AUTHORIZATION_CODE);
    }

    /**
     * @return string
     */
    public function getOperationTypeSubscribeEventEmail(): string
    {
        return $this->getSharedConfig()->getOperationTypeSubscribeEventEmail();
    }

    /**
     * @return string
     */
    public function getOperationTypeUnsubscribeEventEmail(): string
    {
        return $this->getSharedConfig()->getOperationTypeUnsubscribeEventEmail();
    }

    /**
     * @return string
     */
    public function getOperationTypeUpdateFieldsEventEmail(): string
    {
        return $this->getSharedConfig()->getOperationTypeUpdateFieldsEventEmail();
    }
}
