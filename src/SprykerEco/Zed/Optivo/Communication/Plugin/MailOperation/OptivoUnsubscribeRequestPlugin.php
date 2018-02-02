<?php

namespace SprykerEco\Zed\Optivo\Communication\Plugin\MailOperation;

use Generated\Shared\Transfer\OptivoResponseTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface;
use SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface;

/**
 * @method OptivoFacadeInterface getFacade()
 */
class OptivoUnsubscribeRequestPlugin extends AbstractPlugin implements OptivoRequestPluginInterface
{
    /**
     * @param AbstractTransfer|OptivoTransactionalMailRequestTransfer $transfer
     *
     * @return OptivoResponseTransfer
     */
    public function send(AbstractTransfer $transfer)
    {
        return $this->getFacade()
            ->sendTransactionalMailRequest($transfer);
    }
}
