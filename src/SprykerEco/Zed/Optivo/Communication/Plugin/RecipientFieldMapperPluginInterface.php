<?php

namespace SprykerEco\Zed\Optivo\Communication\Plugin;

interface RecipientFieldMapperPluginInterface
{
    /**
     * @param OptivoSubscriberTransfer $optivoSubscriberTransfer
     *
     * @return array
     */
    public function mapTransfer(OptivoSubscriberTransfer $optivoSubscriberTransfer);
}
