<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter;

use Generated\Shared\Transfer\OptivoRequestTransfer;

interface OptivoApiAdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendRequest(OptivoRequestTransfer $optivoRequestTransfer);
}
