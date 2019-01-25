<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Handler\Customer;

use Generated\Shared\Transfer\MailTransfer;

interface CustomerEventHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handle(MailTransfer $mailTransfer): void;
}
