<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;

interface OptivoApiAdapterInterface
{
    /**
     * @param OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return OptivoResponseTransfer
     */
    public function sendRequest(OptivoRequestTransfer $optivoRequestTransfer);
}
