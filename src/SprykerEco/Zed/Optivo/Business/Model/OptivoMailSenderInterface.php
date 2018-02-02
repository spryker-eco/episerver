<?php

namespace SprykerEco\Zed\Optivo\Business\Model;

use Generated\Shared\Transfer\MailTransfer;

interface OptivoMailSenderInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function sendMail(MailTransfer $mailTransfer);
}
