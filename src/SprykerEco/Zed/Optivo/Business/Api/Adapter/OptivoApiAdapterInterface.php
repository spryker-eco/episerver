<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;

interface OptivoApiAdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendRequest(OptivoRequestTransfer $optivoRequestTransfer): OptivoResponseTransfer;
}
