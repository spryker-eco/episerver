<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseConverterInterface
{
    /**
     * @param $response
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function convertResponse(ResponseInterface $response);
}
