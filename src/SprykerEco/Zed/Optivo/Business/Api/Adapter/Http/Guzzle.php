<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use SprykerEco\Zed\Optivo\Business\Exception\ApiHttpRequestException;
use SprykerEco\Zed\Optivo\OptivoConfig;

class Guzzle extends AbstractHttpAdapter
{
    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Optivo\OptivoConfig $config
     */
    public function __construct(OptivoConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $gatewayUrl
     * @param string $data
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function buildRequest($gatewayUrl, $data)
    {
        return new Request('GET', $gatewayUrl, [], $data);
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @throws \SprykerEco\Zed\Optivo\Business\Exception\ApiHttpRequestException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function send($request)
    {
        try {
            $client = new Client([
                'timeout' => $this->config->getRequestTimeout(),
            ]);

            $response = $client->send($request);
        } catch (RequestException $requestException) {
            throw new ApiHttpRequestException(
                $requestException->getMessage(),
                $requestException->getCode(),
                $requestException->getPrevious()
            );
        }

        return $response;
    }
}
