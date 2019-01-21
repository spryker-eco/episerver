<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Communication\Plugin\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Mail\Dependency\Plugin\MailProviderPluginInterface;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 */
class OptivoNewsletterSubscriptionMailPlugin extends AbstractPlugin implements MailProviderPluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function sendMail(MailTransfer $mailTransfer): void
    {
        $this->getFacade()->handleNewsletterSubscription($mailTransfer);
    }
}
