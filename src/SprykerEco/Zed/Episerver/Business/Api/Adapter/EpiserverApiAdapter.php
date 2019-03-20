<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Adapter;

use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\EpiserverResponseTransfer;
use SprykerEco\Zed\Episerver\Business\Api\Adapter\Http\HttpAdapterInterface;
use SprykerEco\Zed\Episerver\Business\Api\Request\RequestUrlBuilderInterface;
use SprykerEco\Zed\Episerver\Business\Api\Response\ResponseConverterInterface;

class EpiserverApiAdapter implements EpiserverApiAdapterInterface
{
    /**
     * @var \SprykerEco\Zed\Episerver\Business\Api\Adapter\Http\HttpAdapterInterface
     */
    protected $httpAdapter;

    /**
     * @var \SprykerEco\Zed\Episerver\Business\Api\Request\RequestUrlBuilderInterface
     */
    protected $requestUrlBuilder;

    /**
     * @var \SprykerEco\Zed\Episerver\Business\Api\Response\ResponseConverterInterface
     */
    protected $responseConverter;

    /**
     * @param \SprykerEco\Zed\Episerver\Business\Api\Adapter\Http\HttpAdapterInterface $httpAdapter
     * @param \SprykerEco\Zed\Episerver\Business\Api\Request\RequestUrlBuilderInterface $requestUrlBuilder
     * @param \SprykerEco\Zed\Episerver\Business\Api\Response\ResponseConverterInterface $responseConverter
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
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $episerverRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverResponseTransfer
     */
    public function sendRequest(EpiserverRequestTransfer $episerverRequestTransfer): EpiserverResponseTransfer
    {
        $requestUrl = $this->requestUrlBuilder->buildUrl($episerverRequestTransfer);

        $response = $this->httpAdapter->sendGetRequest($requestUrl);

        return $this->responseConverter->convertResponse($response);
    }
}
