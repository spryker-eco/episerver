<?php

namespace SprykerEco\Zed\Optivo\Communication\Plugin\MailProvider;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Mail\Dependency\Plugin\MailProviderPluginInterface;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Communication\OptivoCommunicationFactory getFactory()
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
