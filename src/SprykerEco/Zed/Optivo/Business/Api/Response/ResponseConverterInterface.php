<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Response;

use Generated\Shared\Transfer\OptivoResponseTransfer;

interface ResponseConverterInterface
{
    /**
     * @param $response
     *
     * @return OptivoResponseTransfer
     */
    public function convertResponse($response);
}
