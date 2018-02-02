<?php

namespace SprykerEco\Zed\Optivo\Business\Model;

use Generated\Shared\Transfer\MailTransfer;
use SprykerEco\Zed\Optivo\Communication\Plugin\OptivoRequestPluginInterface;

class OptivoMailSender implements OptivoMailSenderInterface
{

    /**
     * @var OptivoRequestPluginInterface[]
     */
    protected $requestPluginsMap;

    /**
     * @param OptivoRequestPluginInterface[] $requestPluginsMap
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
