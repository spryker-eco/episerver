<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
