<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Model;

use Generated\Shared\Transfer\MailTransfer;

class OptivoMailSender implements OptivoMailSenderInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface[]
     */
    protected $requestPluginsMap;

    /**
     * @param \SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface[] $requestPluginsMap
     */
    public function __construct(array $requestPluginsMap)
    {
        $this->requestPluginsMap = $requestPluginsMap;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function sendMail(MailTransfer $mailTransfer)
    {
        $optivoMailRequestTransfer = $mailTransfer->getOptivoMailRequest();
        $transferType = get_class($optivoMailRequestTransfer);

        if (isset($this->requestPluginsMap[$transferType])) {
            $this->requestPluginsMap[$transferType]->send($optivoMailRequestTransfer);
        }
    }
}
