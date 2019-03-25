<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Adapter\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\Episerver\Business\Exception\ApiHttpRequestException;
use SprykerEco\Zed\Episerver\EpiserverConfig;

class GuzzleAdapter implements HttpAdapterInterface
{
    /**
     * @var \SprykerEco\Zed\Episerver\EpiserverConfig
     */
    protected $config;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param \SprykerEco\Zed\Episerver\EpiserverConfig $config
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(EpiserverConfig $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param string $gatewayUrl
     *
     * @throws \SprykerEco\Zed\Episerver\Business\Exception\ApiHttpRequestException
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
