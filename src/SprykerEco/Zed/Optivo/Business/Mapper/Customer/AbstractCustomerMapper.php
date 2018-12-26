<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
    protected const URL_LOGIN = '/login';

    public const KEY_EMAIL = 'bmRecipientId';
    public const KEY_MAILING_ID = 'bmMailingId';
    public const KEY_SALUTATION = 'salutation';
    public const KEY_FIRSTNAME = 'firstname';
    public const KEY_LASTNAME = 'lastname';
    public const KEY_SPRYKER_ID = 'spryker_id';
    public const KEY_CUSTOMER_SHOP_LOCALE = 'customer_shop_locale';
    public const KEY_CUSTOMER_SHOP_URL = 'customer_shop_url';
    public const KEY_CUSTOMER_LOGIN_URL = 'customer_login_url';
    public const KEY_CUSTOMER_RESET_LINK = 'customer_reset_link';


    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

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
        $this->config = $config;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(CustomerTransfer $customerTransfer): OptivoRequestTransfer
    {
        $requestTransfer = new OptivoRequestTransfer();

        $requestTransfer->setAuthorizationCode($this->config->getCustomerListAuthCode());
        $requestTransfer->setOperationType($this->config->getOperationTypeSendEventEmailEmail());
        $requestTransfer->setPayload($this->getPayload($customerTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    protected function getPayload(CustomerTransfer $customerTransfer): array
    {
        $locale = $customerTransfer->getLocale() ?
            $customerTransfer->getLocale()->getLocaleName() :
            $this->localeFacade->getCurrentLocaleName();

        return [
            static::KEY_MAILING_ID => $this->getMailingId(),
            static::KEY_EMAIL => $customerTransfer->getEmail(),
            static::KEY_SALUTATION => $customerTransfer->getSalutation(),
            static::KEY_FIRSTNAME => $customerTransfer->getFirstName(),
            static::KEY_LASTNAME => $customerTransfer->getLastName(),
            static::KEY_SPRYKER_ID => $customerTransfer->getIdCustomer(),
            static::KEY_CUSTOMER_SHOP_LOCALE => $locale,
            static::KEY_CUSTOMER_SHOP_URL => $this->config->getHostYves(),
            static::KEY_CUSTOMER_LOGIN_URL => $this->config->getHostYves() . static::URL_LOGIN,
            static::KEY_CUSTOMER_RESET_LINK => $customerTransfer->getRestorePasswordLink(),
        ];
    }

    /**
     * @return string
     */
    abstract protected function getMailingId(): string;
}
