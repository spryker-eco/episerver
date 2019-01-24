<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
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
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    abstract public function map(MailTransfer $mailTransfer): OptivoRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return array
     */
    abstract protected function getPayload(MailTransfer $mailTransfer): array;

    /**
     * @param string|null $mailTypeName
     *
     * @return string|null
     */
    protected function getMailingId(?string $mailTypeName): ?string
    {
        return $this->config->getMailingIdByMailingTypeName($mailTypeName);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return string
     */
    protected function getLocale(?CustomerTransfer $customerTransfer): string
    {
        $localeName = '';

        if ($customerTransfer !== null && $customerTransfer->getLocale() !== null) {
            $localeName = $customerTransfer->getLocale()->getLocaleName();
        }

        if ($localeName === '') {
            $localeName = $this->localeFacade->getCurrentLocaleName();
        }

        return (string)array_search($localeName, Store::getInstance()->getLocales());
    }
}
