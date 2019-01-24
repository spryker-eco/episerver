<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpAdapterInterface
{
    /**
     * @param string $gatewayUrl
     * @param string $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendGetRequest($gatewayUrl, $data): ResponseInterface;
}
