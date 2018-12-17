<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Response;

use Generated\Shared\Transfer\OptivoResponseTransfer;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Shared\Optivo\OptivoConfig;

class ResponseConverter implements ResponseConverterInterface
{
    public const STATUS_OK = 200;

    /**
     * @param ResponseInterface $response
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function convertResponse(ResponseInterface $response)
    {
        $responseTransfer = new OptivoResponseTransfer();
        $responseTransfer
            ->setStatus($response)
            ->setIsSuccessful($response->getStatusCode() === 200);

        return $responseTransfer;
    }
}
