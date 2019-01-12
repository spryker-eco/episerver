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
     * @param \Generated\Shared\Transfer\OptivoSubscriptionTransfer $transfer
     *
     * @return \Orm\Zed\Optivo\Persistence\SpyOptivoSubscription
     */
    public function createOptivoSubscription(OptivoSubscriptionTransfer $transfer): SpyOptivoSubscription;

    /**
     * @param \Generated\Shared\Transfer\OptivoSubscriptionTransfer $transfer
     *
     * @return \Orm\Zed\Optivo\Persistence\SpyOptivoSubscription
     */
    public function removeOptivoSubscription(OptivoSubscriptionTransfer $transfer): SpyOptivoSubscription;
}
