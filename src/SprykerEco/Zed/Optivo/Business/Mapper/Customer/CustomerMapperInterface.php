<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;

interface CustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function mapMailTransferToOptivoRequestTransfer(MailTransfer $mailTransfer, OptivoRequestTransfer $requestTransfer): OptivoRequestTransfer;
}
