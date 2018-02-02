<?php

namespace SprykerEco\Zed\Optivo\Business\Api;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;
use SprykerEco\Shared\Optivo\OptivoConfig as SharedOptivoConfig;
use SprykerEco\Zed\Optivo\OptivoConfig;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\OptivoApiAdapterInterface;

class OptivoApi implements OptivoApiInterface
{
    /**
     * @var OptivoApiAdapterInterface
     */
    protected $apiAdapter;

    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

    /**
     * @param OptivoApiAdapterInterface $apiAdapter
     * @param OptivoConfig $config
     */
    public function __construct(OptivoApiAdapterInterface $apiAdapter, OptivoConfig $config)
    {
        $this->apiAdapter = $apiAdapter;
        $this->config = $config;
    }

    /**
     * @param OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer)
    {
        $optivoRequestTransfer = new OptivoRequestTransfer();
        $optivoRequestTransfer
            ->setMailingListToken($this->config->getTokenOperationSubscribe())
            ->setServiceType(SharedOptivoConfig::SERVICE_FORM)
            ->setRequestType(SharedOptivoConfig::OPERATION_SUBSCRIBE)
            ->setParameters($this->buildParameters($optivoSubscribeRequestTransfer->toArray()))
        ;

        return $this->apiAdapter->sendRequest($optivoRequestTransfer);
    }

    /**
     * @param OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer)
    {
        $optivoRequestTransfer = new OptivoRequestTransfer();
        $optivoRequestTransfer
            ->setMailingListToken($this->config->getTokenOperationSubscribe())
            ->setServiceType(SharedOptivoConfig::SERVICE_FORM)
            ->setRequestType(SharedOptivoConfig::OPERATION_SUBSCRIBE)
            ->setParameters($this->buildParameters($optivoUnsubscribeRequestTransfer->toArray()))
        ;

        return $this->apiAdapter->sendRequest($optivoRequestTransfer);
    }

    /**
     * @param OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendTransactionalMailRequest(OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer)
    {
        $optivoRequestTransfer = new OptivoRequestTransfer();
        $optivoRequestTransfer
            ->setMailingListToken($this->config->getTokenOperationSubscribe())
            ->setServiceType(SharedOptivoConfig::SERVICE_FORM)
            ->setRequestType(SharedOptivoConfig::OPERATION_SUBSCRIBE)
            ->setParameters($this->buildParameters($optivoTransactionalMailRequestTransfer->toArray()))
        ;

        return $this->apiAdapter->sendRequest($optivoRequestTransfer);
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    protected function buildParameters(array $parameters)
    {
        $result = [];

        foreach ($parameters as $key=>$value) {
            if (is_array($value)) {
                $result+= $value;

                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
