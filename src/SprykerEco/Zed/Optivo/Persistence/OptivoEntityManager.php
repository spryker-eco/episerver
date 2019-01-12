<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Persistence;

use Generated\Shared\Transfer\OptivoSubscriptionTransfer;
use Orm\Zed\Optivo\Persistence\SpyOptivoSubscription;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoPersistenceFactory getFactory()
 */
class OptivoEntityManager extends AbstractEntityManager implements OptivoEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\OptivoSubscriptionTransfer $transfer
     *
     * @return \Orm\Zed\Optivo\Persistence\SpyOptivoSubscription
     */
    public function createOptivoSubscription(OptivoSubscriptionTransfer $transfer): SpyOptivoSubscription
    {
        $entity = $this->getFactory()
            ->createSpyOptivoSubscriptionQuery()
            ->filterByEmail($transfer->getEmail())
            ->findOneOrCreate();

        $entity->setEmail($transfer->getEmail());
        $entity->setOptivoId($transfer->getOptivoId());
        $entity->setFkCustomer($transfer->getFkCustomer());

        $entity->save();

        return $entity;
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoSubscriptionTransfer $transfer
     *
     * @return void
     */
    public function removeOptivoSubscription(OptivoSubscriptionTransfer $transfer): void
    {
        $entity = $this->getFactory()
            ->createSpyOptivoSubscriptionQuery()
            ->filterByEmail($transfer->getEmail())
            ->findOneOrCreate();

        $entity->delete();
    }
}
