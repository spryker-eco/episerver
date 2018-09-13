<?php

namespace SprykerEco\Zed\Optivo\Business;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;
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

    /**
     * @param \Generated\Shared\Transfer\OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer)
    {
        return $this->getFactory()
            ->createOptivoApi()
            ->sendSubscribeRequest($optivoSubscribeRequestTransfer);
    }

    public function handleSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer)
    {
        $this->getFactory()
            ->createOptivoSubscribeNewsletterStrategy()
            ->handle($optivoSubscribeRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer)
    {
        return $this->getFactory()
            ->createOptivoApi()
            ->sendUnsubscribeRequest($optivoUnsubscribeRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendTransactionalMailRequest(OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer)
    {
        return $this->getFactory()
            ->createOptivoApi()
            ->sendTransactionalMailRequest($optivoTransactionalMailRequestTransfer);
    }
}
