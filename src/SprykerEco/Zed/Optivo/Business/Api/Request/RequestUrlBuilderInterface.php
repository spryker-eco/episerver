<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Request;

use Generated\Shared\Transfer\OptivoRequestTransfer;

interface RequestUrlBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return string
     */
    public function buildUrl(OptivoRequestTransfer $optivoRequestTransfer);
}
