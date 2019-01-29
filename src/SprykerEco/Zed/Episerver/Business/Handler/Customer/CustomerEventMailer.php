<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Handler\Customer;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\EpiserverResponseTransfer;
use Generated\Shared\Transfer\MailTransfer;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface;
use SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface;

class CustomerEventMailer implements CustomerEventMailerInterface
{
    /**
     * @var \SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface
     */
    protected $adapter;

    /**
     * @param \SprykerEco\Zed\Episerver\Business\Mapper\Customer\CustomerMapperInterface $mapper
     * @param \SprykerEco\Zed\Episerver\Business\Api\Adapter\EpiserverApiAdapterInterface $adapter
     */
    public function __construct(CustomerMapperInterface $mapper, EpiserverApiAdapterInterface $adapter)
    {
        $this->mapper = $mapper;
        $this->adapter = $adapter;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function mail(MailTransfer $mailTransfer): void
    {
        $requestTransfer = new EpiserverRequestTransfer();
        $mailTransfer = $this->mapMailTransferToEpiserverRequestTransfer($mailTransfer, $requestTransfer);

        $this->send($mailTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverRequestTransfer
     */
    protected function mapMailTransferToEpiserverRequestTransfer(MailTransfer $mailTransfer, EpiserverRequestTransfer $requestTransfer): EpiserverRequestTransfer
    {
        return $this->mapper->mapMailTransferToEpiserverRequestTransfer($mailTransfer, $requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverResponseTransfer
     */
    protected function send(EpiserverRequestTransfer $requestTransfer): EpiserverResponseTransfer
    {
        return $this->adapter->sendRequest($requestTransfer);
    }
}
