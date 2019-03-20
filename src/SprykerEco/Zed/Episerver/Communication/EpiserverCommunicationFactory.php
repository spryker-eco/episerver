<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \SprykerEco\Zed\Episerver\EpiserverConfig getConfig()
 * @method \SprykerEco\Zed\Episerver\Persistence\EpiserverEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Episerver\Business\EpiserverFacadeInterface getFacade()
 */
class EpiserverCommunicationFactory extends AbstractCommunicationFactory
{
}
