<?php

namespace SprykerEco\Zed\Optivo\Business;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory getFactory()
 */
class OptivoFacade extends AbstractFacade implements OptivoFacadeInterface
{
    /**
     * Specification:
     * - Receives the fully configured MailTransfer
     * - Sends the mail
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function sendMail(MailTransfer $mailTransfer)
    {
        $this->getFactory()
            ->createOptivoMailSender()
            ->sendMail($mailTransfer);
    }
}
