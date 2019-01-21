<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractCustomerMapper implements CustomerMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Optivo\OptivoConfig $config
     */
    public function __construct(OptivoConfig $config)
    {
        $this->config = $config;
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
     * @param string $mailTypeName
     *
     * @return string|null
     */
    protected function getMailingId(string $mailTypeName): ?string
    {
        return $this->config->getMailingIdByMailingTypeName($mailTypeName);
    }
}
