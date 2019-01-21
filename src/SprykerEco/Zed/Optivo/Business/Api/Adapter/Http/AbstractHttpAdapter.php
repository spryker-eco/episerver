<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractHttpAdapter implements HttpAdapterInterface
{
    /**
     * @param string $gatewayUrl
     * @param string $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendGetRequest($gatewayUrl, $data): ResponseInterface
    {
        $request = $this->buildRequest($gatewayUrl, $data);

        return $this->send($request);
    }

    /**
     * @param string $gatewayUrl
     * @param string $data
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    abstract protected function buildRequest($gatewayUrl, $data): RequestInterface;

    /**
     * @param object $request
     *
     * @throws \SprykerEco\Zed\Optivo\Business\Exception\ApiHttpRequestException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    abstract protected function send($request): ResponseInterface;
}
