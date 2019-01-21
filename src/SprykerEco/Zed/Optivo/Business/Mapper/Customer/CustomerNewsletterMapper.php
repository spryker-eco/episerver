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
        $payload = [
            static::KEY_EMAIL => $mailTransfer->getNewsletterSubscriber()->getEmail(),
            static::KEY_SPRYKER_ID => $mailTransfer->getNewsletterSubscriber()->getSubscriberKey(),
        ];

        $optInId = $this->getMailingId($mailTransfer->getType());

        if ($optInId !== null) {
            $payload[static::KEY_OPT_IN_ID] = $this->getMailingId($mailTransfer->getType());
        }

        $customerTransfer = $mailTransfer->getCustomer();

        if ($customerTransfer !== null) {
            $payload[static::KEY_SALUTATION] = $customerTransfer->getSalutation();
            $payload[static::KEY_FIRST_NAME] = $customerTransfer->getFirstName();
            $payload[static::KEY_LAST_NAME] = $customerTransfer->getLastName();
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
