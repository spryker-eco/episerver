<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Request;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use SprykerEco\Zed\Optivo\OptivoConfig;

class RequestUrlBuilder implements RequestUrlBuilderInterface
{
    /**
     * @var OptivoConfig
     */
    protected $config;

    /**
     * @param OptivoConfig $config
     */
    public function __construct(OptivoConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return string
     */
    public function buildUrl(OptivoRequestTransfer $optivoRequestTransfer)
    {
        return sprintf(
            '%s/%s/%s/%s?%s',
            $this->config->getRequestBaseUrl(),
            $optivoRequestTransfer->getServiceType(),
            $optivoRequestTransfer->getMailingListToken(),
            $optivoRequestTransfer->getRequestType(),
            http_build_query($optivoRequestTransfer->getParameters())
        );
    }
}
