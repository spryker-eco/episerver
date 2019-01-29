<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Mapper\Customer;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\MailTransfer;

interface CustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverRequestTransfer
     */
    public function mapMailTransferToEpiserverRequestTransfer(MailTransfer $mailTransfer, EpiserverRequestTransfer $requestTransfer): EpiserverRequestTransfer;
}
