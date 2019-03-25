<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Api\Request;

use Generated\Shared\Transfer\EpiserverRequestTransfer;

interface RequestUrlBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $episerverRequestTransfer
     *
     * @return string
     */
    public function buildUrl(EpiserverRequestTransfer $episerverRequestTransfer): string;
}
