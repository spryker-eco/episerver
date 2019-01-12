<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Communication\Plugin\MailOperation;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Communication\OptivoCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 */
class OptivoSubscribeRequestPlugin extends AbstractPlugin implements OptivoRequestPluginInterface
{
    /**
     * @api
     *
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\OptivoSubscribeRequestTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function send(AbstractTransfer $transfer)
    {
        return $this->getFacade()
            ->sendSubscribeRequest($transfer);
    }
}
