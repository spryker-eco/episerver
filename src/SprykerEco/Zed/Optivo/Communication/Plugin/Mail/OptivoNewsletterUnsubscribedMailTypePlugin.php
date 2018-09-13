<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Communication\Plugin\Mail;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;
use Spryker\Zed\Newsletter\Communication\Plugin\Mail\NewsletterUnsubscribedMailTypePlugin;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Communication\OptivoCommunicationFactory getFactory()
 */
class OptivoNewsletterUnsubscribedMailTypePlugin extends NewsletterUnsubscribedMailTypePlugin
{
    /**
     * @param MailBuilderInterface $mailBuilder
     */
    public function build(MailBuilderInterface $mailBuilder)
    {
        parent::build($mailBuilder);
        $this->getFacade()->sendUnsubscribeRequest($this->prepareOptivoUnsubscribeRequestTransfer($mailBuilder));
    }

    /**
     * @param MailBuilderInterface $mailBuilder
     *
     * @return OptivoUnsubscribeRequestTransfer
     */
    protected function prepareOptivoUnsubscribeRequestTransfer(MailBuilderInterface $mailBuilder): OptivoUnsubscribeRequestTransfer
    {
        $transfer = new OptivoUnsubscribeRequestTransfer();
//        $transfer->set($mailBuilder->getMailTransfer()->getNewsletterSubscriber()->getEmail());

        return $transfer;
    }
}
