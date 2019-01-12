<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Strategy;

use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoSubscriptionTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;
use SprykerEco\Zed\Optivo\Business\Api\OptivoApiInterface;
use SprykerEco\Zed\Optivo\Persistence\OptivoEntityManagerInterface;

class OptivoRequestHandler implements OptivoRequestHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\OptivoApiInterface
     */
    protected $api;

    /**
     * @var \SprykerEco\Zed\Optivo\Persistence\OptivoEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \SprykerEco\Zed\Optivo\Business\Api\OptivoApiInterface $api
     */
    public function __construct(OptivoApiInterface $api, OptivoEntityManagerInterface $entityManager)
    {
        $this->api = $api;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoSubscribeRequestTransfer $transfer
     *
     * @return void
     */
    public function handleSubscribeRequest(OptivoSubscribeRequestTransfer $transfer): void
    {
        $response = $this->api->sendSubscribeRequest($transfer);
        $entityTransfer = new OptivoSubscriptionTransfer();
        //Prepare response
        $this->entityManager->createOptivoSubscription($entityTransfer);
    }

    /**
     * @void
     *
     * @param \Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer $transfer
     *
     * @return void
     */
    public function handleUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $transfer): void
    {
        $response = $this->api->sendUnsubscribeRequest($transfer);
        $entityTransfer = new OptivoSubscriptionTransfer();
        //Prepare transfer
        $this->entityManager->removeOptivoSubscription($entityTransfer);
    }
}
