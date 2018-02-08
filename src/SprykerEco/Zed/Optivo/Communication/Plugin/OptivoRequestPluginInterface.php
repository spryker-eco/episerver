<?php

namespace SprykerEco\Zed\Optivo\Communication\Plugin;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface OptivoRequestPluginInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return mixed
     */
    public function send(AbstractTransfer $transfer);
}
