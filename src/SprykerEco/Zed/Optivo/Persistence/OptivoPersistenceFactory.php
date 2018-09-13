<?php

namespace SprykerEco\Zed\Optivo\Persistence;

use Orm\Zed\Optivo\Persistence\SpyOptivoSubscriptionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 */
class OptivoPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return SpyOptivoSubscriptionQuery
     */
    public function createSpyOptivoSubscriptionQuery(): SpyOptivoSubscriptionQuery
    {
        return SpyOptivoSubscriptionQuery::create();
    }
}
