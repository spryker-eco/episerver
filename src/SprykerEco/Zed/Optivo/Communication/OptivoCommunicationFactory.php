<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 */
class OptivoCommunicationFactory extends AbstractCommunicationFactory
{
}
