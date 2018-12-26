<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpAdapterInterface
{
    /**
     * @param string $gatewayUrl
     * @param string $data
     *
     * @return ResponseInterface
     */
    public function sendGetRequest($gatewayUrl, $data);
}
