<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Communication\Plugin\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Mail\Dependency\Plugin\MailProviderPluginInterface;

/**
 * @method \SprykerEco\Zed\Episerver\Business\EpiserverFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Episerver\Business\EpiserverBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Episerver\EpiserverConfig getConfig()
 *
 * @SuppressWarnings(PHPMD.NewPluginExtensionModuleRule)
 */
class EpiserverNewsletterSubscriptionMailPlugin extends AbstractPlugin implements MailProviderPluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function sendMail(MailTransfer $mailTransfer): void
    {
        $this->getFacade()->mailNewsletterSubscription($mailTransfer);
    }
}
