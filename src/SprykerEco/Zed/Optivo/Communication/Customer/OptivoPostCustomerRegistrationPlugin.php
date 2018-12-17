<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\CustomerExtension\Dependency\Plugin\PostCustomerRegistrationPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory getFactory()
 */
class OptivoPostCustomerRegistrationPlugin extends AbstractPlugin implements PostCustomerRegistrationPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function execute(CustomerTransfer $customerTransfer): void
    {
        $this->getFacade()->handleCustomerRegistrationEvent($customerTransfer);
    }
}