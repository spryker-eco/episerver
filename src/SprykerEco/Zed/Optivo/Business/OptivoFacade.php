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
     * @param OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer
     *
     * @return void
     */
    public function handleSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer): void
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
    public function handleUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer): void
    {
        $this->getFactory()
            ->createOptivoRequestHandler()
            ->handleUnsubscribeRequest($optivoUnsubscribeRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer
     *
     * @return void
     */
    public function handleTransactionalRequest(OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer): void
    {
        $this->getFactory()
            ->createOptivoApi()
            ->sendTransactionalMailRequest($optivoTransactionalMailRequestTransfer);
    }
}
