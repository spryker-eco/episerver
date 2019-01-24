<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Communication\Plugin;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface OptivoRequestPluginInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return void
     */
    public function send(AbstractTransfer $transfer): void;
}
