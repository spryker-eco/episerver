<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Api\Request;

use Generated\Shared\Transfer\OptivoRequestTransfer;

class RequestUrlBuilder extends AbstractRequestUrlBuilder
{
    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return string
     */
    public function buildUrl(OptivoRequestTransfer $optivoRequestTransfer): string
    {
        return sprintf(
            '%s/%s/%s/%s?%s',
            $this->config->getRequestBaseUrl(),
            $this->config->getServiceFormType(),
            $optivoRequestTransfer->getAuthorizationCode(),
            $optivoRequestTransfer->getOperationType(),
            http_build_query($optivoRequestTransfer->getPayload())
        );
    }
}
