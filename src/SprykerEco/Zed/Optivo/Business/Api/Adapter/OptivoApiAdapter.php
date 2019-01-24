<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Optivo\Business\Api\Adapter;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;
use SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\HttpAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface;

class OptivoApiAdapter implements OptivoApiAdapterInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\HttpAdapterInterface
     */
    protected $httpAdapter;

    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface
     */
    protected $requestUrlBuilder;

    /**
     * @var \SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface
     */
    protected $responseConverter;

    /**
     * @param \SprykerEco\Zed\Optivo\Business\Api\Adapter\Http\HttpAdapterInterface $httpAdapter
     * @param \SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface $requestUrlBuilder
     * @param \SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface $responseConverter
     */
    public function __construct(
        HttpAdapterInterface $httpAdapter,
        RequestUrlBuilderInterface $requestUrlBuilder,
        ResponseConverterInterface $responseConverter
    ) {
        $this->httpAdapter = $httpAdapter;
        $this->requestUrlBuilder = $requestUrlBuilder;
        $this->responseConverter = $responseConverter;
    }

    /**
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
     */
    public function sendRequest(OptivoRequestTransfer $optivoRequestTransfer): OptivoResponseTransfer
    {
        $requestUrl = $this->requestUrlBuilder->buildUrl($optivoRequestTransfer);

        $response = $this->httpAdapter->sendGetRequest($requestUrl, '');

        return $this->responseConverter->convertResponse($response);
    }
}
