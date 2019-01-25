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
    public function getOrderListAuthorizationCode(): string
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
     * @param string $mailingTypeName
     *
     * @return string|null
     */
    public function getMailingIdByMailingTypeName(string $mailingTypeName): ?string
    {
        $mailingIdList = $this->get(OptivoConstants::CONFIGURATION_DEFAULT_MAILING_ID_LIST);

        if (!empty($mailingIdList[$mailingTypeName])) {
            return $mailingIdList[$mailingTypeName];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getOperationSendTransactionEmail(): string
    {
        return $this->getSharedConfig()->getOperationSendTransactionEmail();
    }

    /**
     * @return string
     */
    public function getCustomerListAuthorizationCode(): string
    {
        return $this->get(OptivoConstants::CUSTOMER_LIST_AUTHORIZATION_CODE);
    }

    /**
     * @return string
     */
    public function getCustomerNewsLetterListAuthorizationCode(): string
    {
        return $this->get(OptivoConstants::CUSTOMER_NEWSLETTER_AUTHORIZATION_CODE);
    }

    /**
     * @return string
     */
    public function getOperationSubscribeEventEmail(): string
    {
        return $this->getSharedConfig()->getOperationSubscribeEventEmail();
    }

    /**
     * @return string
     */
    public function getOperationUnsubscribeEventEmail(): string
    {
        return $this->getSharedConfig()->getOperationUnsubscribeEventEmail();
    }

    /**
     * @return string
     */
    public function getOperationUpdateFieldsEventEmail(): string
    {
        return $this->getSharedConfig()->getOperationUpdateFieldsEventEmail();
    }
}
