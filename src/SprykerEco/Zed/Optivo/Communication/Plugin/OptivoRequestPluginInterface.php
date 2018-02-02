<?php

namespace SprykerEco\Zed\Optivo\Communication\Plugin;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface OptivoRequestPluginInterface
{
    /**
     * @param AbstractTransfer $transfer
     *
     * @return mixed
     */
    public function send(AbstractTransfer $transfer);
}
