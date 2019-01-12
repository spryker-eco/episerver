<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business;

use Generated\Shared\Transfer\MailTransfer;

interface OptivoFacadeInterface
{
    /**
     * Specification:
     *  - This method is used by OptivoNewOrderPlugin Oms command for sending data to Optivo API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleNewOrderEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - This method is used by OptivoOrderCanceledPlugin Oms command for sending data to Optivo API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleOrderCanceledEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - This method is used by OptivoPaymentNotReceivedPlugin Oms command for sending data to Optivo API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - This method is used by OptivoShippingConfirmationPlugin Oms command for sending data to Optivo API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function handleShippingConfirmationEvent(int $idSalesOrder): void;

    /**
     * Specification:
     *  - Handle customer event. It uses MailTransfer as the param which has been got from MailerTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleCustomerEvent(MailTransfer $mailTransfer): void;
}
