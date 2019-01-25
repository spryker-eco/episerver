<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\Optivo\Business\Exception\ApiHttpRequestException;
use SprykerEco\Zed\Optivo\OptivoConfig;

class GuzzleAdapter implements HttpAdapterInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param \SprykerEco\Zed\Optivo\OptivoConfig $config
     */
    public function __construct(OptivoConfig $config)
    {
        $this->config = $config;

        $this->client = new Client([
            RequestOptions::TIMEOUT => $this->config->getRequestTimeout(),
        ]);
    }

    /**
     * @param string $gatewayUrl
     *
     * @throws \SprykerEco\Zed\Optivo\Business\Exception\ApiHttpRequestException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendGetRequest(string $gatewayUrl): ResponseInterface
    {
        try {
            $response = $this->client->get($gatewayUrl);
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
