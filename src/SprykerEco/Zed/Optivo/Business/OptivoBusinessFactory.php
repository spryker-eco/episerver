<?php

namespace SprykerEco\Zed\Optivo\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSender;
use SprykerEco\Zed\Optivo\Business\Model\OptivoMailSenderInterface;

/**
 * @method \SprykerEco\Zed\Optivo\OptivoConfig getConfig()
 * @method \SprykerEco\Zed\Optivo\Persistence\OptivoQueryContainer getQueryContainer()
 */
class OptivoBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return OptivoMailSenderInterface
     */
    public function createOptivoMailSender()
    {
        return new OptivoMailSender();
    }
}
