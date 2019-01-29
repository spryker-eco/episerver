<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Mapper\Customer;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\MailTransfer;

class CustomerMapper extends AbstractCustomerMapper
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverRequestTransfer
     */
    public function mapMailTransferToEpiserverRequestTransfer(MailTransfer $mailTransfer, EpiserverRequestTransfer $requestTransfer): EpiserverRequestTransfer
    {
        $requestTransfer->setAuthorizationCode($this->config->getCustomerListAuthorizationCode());
        $requestTransfer->setOperationType($this->config->getOperationSendTransactionEmail());
        $requestTransfer->setPayload($this->buildPayload($mailTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return array
     */
    protected function buildPayload(MailTransfer $mailTransfer): array
    {
        $customerTransfer = $mailTransfer->getCustomer();

        $payload = [
            static::KEY_CUSTOMER_SHOP_LOCALE => $this->getLocale($customerTransfer),
            static::KEY_CUSTOMER_SHOP_URL => $this->config->getHostYves(),
            static::KEY_CUSTOMER_LOGIN_URL => $this->config->getHostYves() . static::URL_LOGIN,
        ];

        if ($customerTransfer !== null) {
            $payload[static::KEY_EMAIL] = $customerTransfer->getEmail();
            $payload[static::KEY_SALUTATION] = $customerTransfer->getSalutation();
            $payload[static::KEY_FIRST_NAME] = $customerTransfer->getFirstName();
            $payload[static::KEY_LAST_NAME] = $customerTransfer->getLastName();
            $payload[static::KEY_SPRYKER_ID] = $customerTransfer->getIdCustomer();
            $payload[static::KEY_CUSTOMER_RESET_LINK] = $customerTransfer->getRestorePasswordLink();
        }

        if ($mailTransfer->getType() !== null) {
            $payload[static::KEY_MAILING_ID] = $this->getMailingId($mailTransfer->getType());
        }

        return $payload;
    }
}
