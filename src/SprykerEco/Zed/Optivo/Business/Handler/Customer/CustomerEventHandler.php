<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Handler\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface;

class CustomerEventHandler implements CustomerEventHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @param \SprykerEco\Zed\Optivo\Business\Mapper\Customer\CustomerMapperInterface $mapper
     * @param OptivoApiAdapterInterface $adapter
     */
    public function __construct(CustomerMapperInterface $mapper, OptivoApiAdapterInterface $adapter)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handle(CustomerTransfer $customerTransfer): void
    {
        $transfer = $this->map($customerTransfer);
        $this->send($transfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    protected function map(CustomerTransfer $customerTransfer): OptivoRequestTransfer
    {
        return $this->mapper->map($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $requestTransfer
     *
     * @return OptivoResponseTransfer
     */
    protected function send(OptivoRequestTransfer $requestTransfer): OptivoResponseTransfer
    {
        return $this->adapter->sendRequest($requestTransfer);
    }
}
