<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Dependency\Facade;

use Generated\Shared\Transfer\MoneyTransfer;

interface OptivoToMoneyFacadeInterface
{
    /**
     * @param int $value
     *
     * @return \Generated\Shared\Transfer\MoneyTransfer
     */
    public function fromInteger(int $value): MoneyTransfer;

    /**
     * @param \Generated\Shared\Transfer\MoneyTransfer $moneyTransfer
     *
     * @return string
     */
    public function formatWithSymbol(MoneyTransfer $moneyTransfer): string;
}
