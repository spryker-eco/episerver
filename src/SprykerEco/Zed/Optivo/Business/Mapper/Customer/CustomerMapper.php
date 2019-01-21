<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoConfig;

class CustomerMapper extends AbstractCustomerMapper
{
    /**
     * @var \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Optivo\OptivoConfig $config
     * @param \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface $localeFacade
     */
    public function __construct(OptivoConfig $config, OptivoToLocaleFacadeInterface $localeFacade)
    {
        parent::__construct($config);

        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(MailTransfer $mailTransfer): OptivoRequestTransfer
    {
        $requestTransfer = new OptivoRequestTransfer();

        $requestTransfer->setAuthorizationCode($this->config->getCustomerListAuthCode());
        $requestTransfer->setOperationType($this->config->getOperationTypeSendTransactionEmail());
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

        return [
            static::KEY_MAILING_ID => $this->getMailingId($mailTransfer->getType()),
            static::KEY_EMAIL => $customerTransfer->getEmail(),
            static::KEY_SALUTATION => $customerTransfer->getSalutation(),
            static::KEY_FIRST_NAME => $customerTransfer->getFirstName(),
            static::KEY_LAST_NAME => $customerTransfer->getLastName(),
            static::KEY_SPRYKER_ID => $customerTransfer->getIdCustomer(),
            static::KEY_CUSTOMER_SHOP_LOCALE => $this->getLocale($customerTransfer),
            static::KEY_CUSTOMER_SHOP_URL => $this->config->getHostYves(),
            static::KEY_CUSTOMER_LOGIN_URL => $this->config->getHostYves() . static::URL_LOGIN,
            static::KEY_CUSTOMER_RESET_LINK => $customerTransfer->getRestorePasswordLink(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    protected function getLocale(CustomerTransfer $customerTransfer): string
    {
        if ($customerTransfer->getLocale() !== null) {
            return $customerTransfer->getLocale()->getLocaleName();
        }

        return $this->localeFacade->getCurrentLocaleName();
    }
}