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

    /**
     * @param OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer
     *
     * @return void
     */
    public function handleSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer)
    {
        $this->getFactory()
            ->createOptivoRequestHandler()
            ->handleSubscribeRequest($optivoSubscribeRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer
     *
     * @return void
     */
    public function sendUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer)
    {
        $this->getFactory()
            ->createOptivoRequestHandler()
            ->handleUnsubscribeRequest($optivoUnsubscribeRequestTransfer);
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
