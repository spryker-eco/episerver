<?php

namespace SprykerEco\Zed\Optivo\Business\Api;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;

interface OptivoApiInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer);

    /**
     * @param \Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendTransactionalMailRequest(OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer);
}
