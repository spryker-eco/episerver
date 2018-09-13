<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Persistence;

use Generated\Shared\Transfer\OptivoSubscriptionTransfer;
use Orm\Zed\Optivo\Persistence\SpyOptivoSubscription;

interface OptivoEntityManagerInterface
{
    /**
     * @param OptivoSubscriptionTransfer $transfer
     *
     * @return SpyOptivoSubscription
     */
    public function createOptivoSubscription(OptivoSubscriptionTransfer $transfer): SpyOptivoSubscription;

    /**
     * @param OptivoSubscriptionTransfer $transfer
     *
     * @return SpyOptivoSubscription
     */
    public function removeOptivoSubscription(OptivoSubscriptionTransfer $transfer): SpyOptivoSubscription;
}
