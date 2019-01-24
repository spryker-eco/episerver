<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     *  - Handle customer event
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleCustomerEvent(MailTransfer $mailTransfer): void;

    /**
     * Specification:
     *  - Handle newsletter subscription event
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleNewsletterSubscription(MailTransfer $mailTransfer): void;
}
