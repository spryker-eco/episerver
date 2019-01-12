<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Persistence;

use Orm\Zed\Optivo\Persistence\SpyOptivoSubscriptionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoRepositoryInterface getRepository()
 */
class OptivoPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Optivo\Persistence\SpyOptivoSubscriptionQuery
     */
    public function createSpyOptivoSubscriptionQuery(): SpyOptivoSubscriptionQuery
    {
        return SpyOptivoSubscriptionQuery::create();
    }
}
