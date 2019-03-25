<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Response;

use Generated\Shared\Transfer\EpiserverResponseTransfer;
use Psr\Http\Message\ResponseInterface;

interface ResponseConverterInterface
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Generated\Shared\Transfer\EpiserverResponseTransfer
     */
    public function convertResponse(ResponseInterface $response): EpiserverResponseTransfer;
}
