<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Strategy;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;

interface OptivoRequestHandlerInterface
{
    /**
     * @param OptivoSubscribeRequestTransfer $transfer
     *
     * @return void
     */
    public function handleSubscribeRequest(OptivoSubscribeRequestTransfer $transfer): void;

    /**
     * @param OptivoUnsubscribeRequestTransfer $transfer
     *
     * @return void
     */
    public function handleUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $transfer): void;
}