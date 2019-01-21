<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Request;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractRequestUrlBuilder implements RequestUrlBuilderInterface
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
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return string
     */
    abstract public function buildUrl(OptivoRequestTransfer $optivoRequestTransfer): string;
}
