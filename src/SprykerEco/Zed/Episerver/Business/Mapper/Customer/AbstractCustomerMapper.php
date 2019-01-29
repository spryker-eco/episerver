<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface;
use SprykerEco\Zed\Episerver\EpiserverConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
    protected const URL_LOGIN = '/login';
    protected const KEY_EMAIL = 'bmRecipientId';
    protected const KEY_OPT_IN_ID = 'bmOptInId';
    protected const KEY_MAILING_ID = 'bmMailingId';
    protected const KEY_SALUTATION = 'salutation';
    protected const KEY_FIRST_NAME = 'firstname';
    protected const KEY_LAST_NAME = 'lastname';
    protected const KEY_SPRYKER_ID = 'spryker_id';
    protected const KEY_CUSTOMER_SHOP_LOCALE = 'customer_shop_locale';
    protected const KEY_CUSTOMER_SHOP_URL = 'customer_shop_url';
    protected const KEY_CUSTOMER_LOGIN_URL = 'customer_login_url';
    protected const KEY_CUSTOMER_RESET_LINK = 'customer_reset_link';
    protected const KEY_CUSTOMER_SUBSCRIBER_KEY = 'subscriber_key';
    protected const KEY_REMOVE_ID = 'bmRemoveId';

    /**
     * @var \SprykerEco\Zed\Episerver\EpiserverConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Episerver\EpiserverConfig $config
     * @param \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface $localeFacade
     */
    public function __construct(EpiserverConfig $config, EpiserverToLocaleFacadeInterface $localeFacade)
    {
        $this->config = $config;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return array
     */
    abstract protected function buildPayload(MailTransfer $mailTransfer): array;

    /**
     * @param string $mailTypeName
     *
     * @return string|null
     */
    protected function getMailingId(string $mailTypeName): ?string
    {
        return $this->config->getMailingIdByMailingTypeName($mailTypeName);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return string
     */
    protected function getLocale(?CustomerTransfer $customerTransfer): string
    {
        if ($customerTransfer !== null &&
            $customerTransfer->getLocale() !== null &&
            $customerTransfer->getLocale()->getLocaleName() !== null) {
            return $this->getLocaleShortName($customerTransfer->getLocale()->getLocaleName());
        }

        return $this->getLocaleShortName($this->localeFacade->getLocaleName());
    }

    /**
     * @param string|null $localeName
     *
     * @return string
     */
    protected function getLocaleShortName(?string $localeName): string
    {
        if ($localeName === null) {
            return '';
        }

        return (string)array_search($localeName, Store::getInstance()->getLocales());
    }
}
