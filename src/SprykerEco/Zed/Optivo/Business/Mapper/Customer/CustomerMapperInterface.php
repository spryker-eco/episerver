<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;

interface CustomerMapperInterface
{
    public const URL_LOGIN = '/login';
    public const KEY_EMAIL = 'bmRecipientId';
    public const KEY_OPT_IN_ID = 'bmOptInId';
    public const KEY_MAILING_ID = 'bmMailingId';
    public const KEY_SALUTATION = 'salutation';
    public const KEY_FIRST_NAME = 'firstname';
    public const KEY_LAST_NAME = 'lastname';
    public const KEY_SPRYKER_ID = 'spryker_id';
    public const KEY_CUSTOMER_SHOP_LOCALE = 'customer_shop_locale';
    public const KEY_CUSTOMER_SHOP_URL = 'customer_shop_url';
    public const KEY_CUSTOMER_LOGIN_URL = 'customer_login_url';
    public const KEY_CUSTOMER_RESET_LINK = 'customer_reset_link';

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(MailTransfer $mailTransfer): OptivoRequestTransfer;
}
