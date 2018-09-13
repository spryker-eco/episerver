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
     * @var OptivoApiInterface
     */
    protected $api;

    /**
     * @var OptivoEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param OptivoApiInterface $api
     */
    public function __construct(OptivoApiInterface $api, OptivoEntityManagerInterface $entityManager)
    {
        $this->api = $api;
        $this->entityManager = $entityManager;
    }

    /**
     * @param OptivoSubscribeRequestTransfer $transfer
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
     * @param OptivoUnsubscribeRequestTransfer $transfer
     *
     * @void
     */
    public function handleUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $transfer): void
    {
        // TODO: Implement handleUnsubscribeRequest() method.
    }
}
