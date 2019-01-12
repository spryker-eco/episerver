<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter\Http;

interface HttpAdapterInterface
{
    /**
     * @param string $gatewayUrl
     * @param string $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendGetRequest($gatewayUrl, $data);
}
