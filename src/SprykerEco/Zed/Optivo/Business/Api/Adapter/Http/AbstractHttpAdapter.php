<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
