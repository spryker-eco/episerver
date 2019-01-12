<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Communication\Plugin\Mail;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;
use Spryker\Zed\Newsletter\Communication\Plugin\Mail\NewsletterSubscribedMailTypePlugin;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Communication\OptivoCommunicationFactory getFactory()
 */
class OptivoNewsletterSubscribedMailTypePlugin extends NewsletterSubscribedMailTypePlugin
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return void
     */
    public function build(MailBuilderInterface $mailBuilder)
    {
        parent::build($mailBuilder);
        $this->getFacade()->sendSubscribeRequest($this->prepareOptivoSubscribeRequestTransfer($mailBuilder));
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return \Generated\Shared\Transfer\OptivoSubscribeRequestTransfer
     */
    protected function prepareOptivoSubscribeRequestTransfer(MailBuilderInterface $mailBuilder): OptivoSubscribeRequestTransfer
    {
        $transfer = new OptivoSubscribeRequestTransfer();
        $transfer->setSubscriber($mailBuilder->getMailTransfer()->getNewsletterSubscriber()->getEmail());

        return $transfer;
    }
}
