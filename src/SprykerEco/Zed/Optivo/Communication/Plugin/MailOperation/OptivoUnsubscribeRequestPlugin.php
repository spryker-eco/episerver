<?php

namespace SprykerEco\Zed\Optivo\Communication\Plugin\MailOperation;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Communication\OptivoCommunicationFactory getFactory()
 */
class OptivoUnsubscribeRequestPlugin extends AbstractPlugin implements OptivoRequestPluginInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function send(AbstractTransfer $transfer)
    {
        return $this->getFacade()
            ->sendTransactionalMailRequest($transfer);
    }
}
