<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Adapter;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\EpiserverResponseTransfer;

interface EpiserverApiAdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $episerverRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverResponseTransfer
     */
    public function sendRequest(EpiserverRequestTransfer $episerverRequestTransfer): EpiserverResponseTransfer;
}
