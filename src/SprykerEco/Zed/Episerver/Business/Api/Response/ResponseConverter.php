<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Response;

use Generated\Shared\Transfer\EpiserverResponseTransfer;
use Psr\Http\Message\ResponseInterface;

class ResponseConverter implements ResponseConverterInterface
{
    protected const STATUS_OK = 200;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Generated\Shared\Transfer\EpiserverResponseTransfer
     */
    public function convertResponse(ResponseInterface $response): EpiserverResponseTransfer
    {
        $responseTransfer = new EpiserverResponseTransfer();
        $responseTransfer
            ->setStatus($response->getStatusCode())
            ->setIsSuccessful($this->isSuccessful($response));

        return $responseTransfer;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function isSuccessful(ResponseInterface $response): bool
    {
        return $response->getStatusCode() === static::STATUS_OK;
    }
}
