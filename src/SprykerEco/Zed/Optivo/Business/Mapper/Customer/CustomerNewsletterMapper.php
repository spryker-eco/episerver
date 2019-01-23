<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Spryker\Zed\Newsletter\Communication\Plugin\Mail\NewsletterSubscribedMailTypePlugin;
use Spryker\Zed\Newsletter\Communication\Plugin\Mail\NewsletterUnsubscribedMailTypePlugin;

class CustomerNewsletterMapper extends AbstractCustomerMapper
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(MailTransfer $mailTransfer): OptivoRequestTransfer
    {
        $requestTransfer = new OptivoRequestTransfer();

        $requestTransfer->setAuthorizationCode($this->config->getCustomerNewsLetterListAuthCode());
        $requestTransfer->setOperationType($this->resolveOperationType($mailTransfer->getType()));
        $requestTransfer->setPayload($this->getPayload($mailTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return array
     */
    protected function getPayload(MailTransfer $mailTransfer): array
    {
        $customerTransfer = $mailTransfer->getCustomer();

        $payload = [
            static::KEY_CUSTOMER_SHOP_URL => $this->config->getHostYves(),
            static::KEY_CUSTOMER_LOGIN_URL => $this->config->getHostYves() . static::URL_LOGIN,
            static::KEY_CUSTOMER_SHOP_LOCALE => $this->getLocale($customerTransfer),
        ];

        $optInId = $this->getMailingId($mailTransfer->getType());

        if ($optInId !== null) {
            $payload[static::KEY_OPT_IN_ID] = $optInId;
        }

        if ($customerTransfer !== null) {
            $payload[static::KEY_SALUTATION] = $customerTransfer->getSalutation();
            $payload[static::KEY_FIRST_NAME] = $customerTransfer->getFirstName();
            $payload[static::KEY_LAST_NAME] = $customerTransfer->getLastName();
            $payload[static::KEY_SPRYKER_ID] = $customerTransfer->getIdCustomer();
            $payload[static::KEY_CUSTOMER_RESET_LINK] = $customerTransfer->getRestorePasswordLink();
            $payload[static::KEY_EMAIL] = $customerTransfer->getEmail();
        }

        $newsletterSubscriber = $mailTransfer->getNewsletterSubscriber();

        if ($newsletterSubscriber !== null) {
            $payload[static::KEY_EMAIL] = $newsletterSubscriber->getEmail();
            $payload[static::KEY_CUSTOMER_SUBSCRIBER_KEY] = $newsletterSubscriber->getSubscriberKey();
        }

        return $payload;
    }

    /**
     * @param string $mailTypeName
     *
     * @return string
     */
    protected function resolveOperationType(string $mailTypeName): string
    {
        if ($mailTypeName === NewsletterSubscribedMailTypePlugin::MAIL_TYPE) {
            return $this->config->getOperationTypeSubscribeEventEmail();
        }

        if ($mailTypeName === NewsletterUnsubscribedMailTypePlugin::MAIL_TYPE) {
            return $this->config->getOperationTypeUnsubscribeEventEmail();
        }

        return $this->config->getOperationTypeUpdateFieldsEventEmail();
    }
}
