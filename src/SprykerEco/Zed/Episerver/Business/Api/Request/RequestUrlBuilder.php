<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Request;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use SprykerEco\Zed\Episerver\EpiserverConfig;

class RequestUrlBuilder implements RequestUrlBuilderInterface
{
    /**
     * @var \SprykerEco\Zed\Episerver\EpiserverConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Episerver\EpiserverConfig $config
     */
    public function __construct(EpiserverConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $episerverRequestTransfer
     *
     * @return string
     */
    public function buildUrl(EpiserverRequestTransfer $episerverRequestTransfer): string
    {
        return sprintf(
            '%s/%s/%s/%s?%s',
            $this->config->getRequestBaseUrl(),
            $this->config->getServiceFormType(),
            $episerverRequestTransfer->getAuthorizationCode(),
            $episerverRequestTransfer->getOperationType(),
            http_build_query($episerverRequestTransfer->getPayload())
        );
    }
}
