<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Response;

interface ResponseConverterInterface
{
    /**
     * @param $response
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function convertResponse($response);
}
