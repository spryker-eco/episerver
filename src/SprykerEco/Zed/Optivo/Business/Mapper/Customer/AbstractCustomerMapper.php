<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
    protected const LOGIN_URL = '/login';

    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Optivo\OptivoConfig $config
     * @param \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface $localeFacade
     */
    public function __construct(OptivoConfig $config, OptivoToLocaleFacadeInterface $localeFacade)
    {
        $this->config = $config;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(CustomerTransfer $customerTransfer): OptivoRequestTransfer
    {
        $OptivoRequestTransfer = new OptivoRequestTransfer();
        $OptivoRequestTransfer->setEvent($this->getEvent());
        $OptivoRequestTransfer->setTransactionId(uniqid('customer_'));
        $OptivoRequestTransfer->setPayload($this->getPayload($customerTransfer));

        return $OptivoRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    protected function getPayload(CustomerTransfer $customerTransfer): array
    {
        return [
            'Customer' => [
                'LoginUrl' => $this->config->getHostYves() . static::LOGIN_URL,
                'ResetLink' => $customerTransfer->getRestorePasswordLink(),
                'Mail' => $customerTransfer->getEmail(),
                'Salutation' => $customerTransfer->getSalutation(),
                'Firstname' => $customerTransfer->getFirstName(),
                'Lastname' => $customerTransfer->getLastName(),
                'Id' => $customerTransfer->getIdCustomer(),
                'Language' => $customerTransfer->getLocale() ? $customerTransfer->getLocale()->getLocaleName() : $this->localeFacade->getCurrentLocaleName(),
            ],
            'Shop' => [
                'ShopLocale' => $this->localeFacade->getCurrentLocaleName(),
                'ShopUrl' => $this->config->getHostYves(),
            ],
        ];
    }

    /**
     * @return string
     */
    abstract protected function getEvent(): string;
}
