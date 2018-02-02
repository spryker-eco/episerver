<?php

namespace SprykerEco\Zed\Optivo\Business\Api\Adapter;

use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OptivoResponseTransfer;
use SprykerEco\Zed\Optivo\Business\Api\Http\HttpAdapterInterface;
use SprykerEco\Zed\Optivo\Business\Api\Request\RequestUrlBuilderInterface;
use SprykerEco\Zed\Optivo\Business\Api\Response\ResponseConverterInterface;

class OptivoApiAdapter implements OptivoApiAdapterInterface
{
    /**
     * @var HttpAdapterInterface
     */
    protected $httpAdapter;

    /**
     * @var RequestUrlBuilderInterface
     */
    protected $requestUrlBuilder;

    /**
     * @var ResponseConverterInterface
     */
    protected $responseConverter;

    /**
     * @param HttpAdapterInterface $httpAdapter
     * @param RequestUrlBuilderInterface $requestUrlBuilder
     * @param ResponseConverterInterface $responseConverter
     */
    public function __construct(
        HttpAdapterInterface $httpAdapter,
        RequestUrlBuilderInterface $requestUrlBuilder,
        ResponseConverterInterface $responseConverter
    )
    {
        $this->httpAdapter = $httpAdapter;
        $this->requestUrlBuilder = $requestUrlBuilder;
        $this->responseConverter = $responseConverter;
    }

    /**
     * @param OptivoRequestTransfer $optivoRequestTransfer
     *
     * @return OptivoResponseTransfer
     */
    public function sendRequest(OptivoRequestTransfer $optivoRequestTransfer)
    {
        $requestUrl = $this->requestUrlBuilder->buildUrl($optivoRequestTransfer);

        $response = $this->httpAdapter->sendGetRequest($requestUrl, '');

        return $this->responseConverter->convertResponse($response);
    }
}
