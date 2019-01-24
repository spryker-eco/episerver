<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
    protected function buildRequest($gatewayUrl, $data): RequestInterface
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
    protected function send($request): ResponseInterface
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
