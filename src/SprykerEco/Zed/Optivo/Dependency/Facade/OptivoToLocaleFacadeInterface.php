<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Dependency\Facade;

interface OptivoToLocaleFacadeInterface
{
    /**
     * @return string|null
     */
    public function getCurrentLocaleName(): ?string;
}
