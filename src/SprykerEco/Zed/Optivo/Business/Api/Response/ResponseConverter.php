<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Response;

use Generated\Shared\Transfer\OptivoResponseTransfer;
use SprykerEco\Shared\Optivo\OptivoConfig;

class ResponseConverter implements ResponseConverterInterface
{
    /**
     * @param $response
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function convertResponse($response)
    {
        $responseTransfer = new OptivoResponseTransfer();
        $responseTransfer
            ->setStatus($response)
            ->setIsSuccessful($this->isSuccessful($response));

        return $responseTransfer;
    }

    /**
     * @param $response
     *
     * @return bool
     */
    protected function isSuccessful($response)
    {
        return strstr($response, OptivoConfig::RESPONSE_OK) === 0;
    }
}
