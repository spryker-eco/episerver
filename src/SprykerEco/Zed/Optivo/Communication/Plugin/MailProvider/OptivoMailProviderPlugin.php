<?php

namespace SprykerEco\Zed\Optivo\Cpmmunication\Plugin\MailProvider;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Mail\Dependency\Plugin\MailProviderPluginInterface;
use SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface;

/**
 * @method OptivoFacadeInterface getFacade()
 */
class OptivoMailProviderPlugin extends AbstractPlugin implements MailProviderPluginInterface
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
        $this->getFacade()
            ->sendMail($mailTransfer);
    }
}
