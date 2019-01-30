<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Dependency\Facade;

interface EpiserverToLocaleFacadeInterface
{
    /**
     * @module Locale|Money|Product
     *
     * @return string|null
     */
    public function getLocaleName();
}
