<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Handler\Customer;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface;

class CustomerEventHandler implements CustomerEventHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface
     */
    protected $adapter;

    /**
     * @param \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface $mapper
     * @param \SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface $adapter
     */
    public function __construct(CustomerMapperInterface $mapper, OptivoApiAdapterInterface $adapter)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handle(MailTransfer $mailTransfer): void
    {
        $requestTransfer = new OptivoRequestTransfer();
        $mailTransfer = $this->mapMailTransferToOptivoRequestTransfer($mailTransfer, $requestTransfer);

        $this->send($mailTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    protected function mapMailTransferToOptivoRequestTransfer(MailTransfer $mailTransfer, OptivoRequestTransfer $requestTransfer): OptivoRequestTransfer
    {
        return $this->mapper->mapMailTransferToOptivoRequestTransfer($mailTransfer, $requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    protected function send(OptivoRequestTransfer $requestTransfer): OptivoResponseTransfer
    {
        return $this->adapter->sendRequest($requestTransfer);
    }
}
