<?php

namespace SprykerEco\Zed\Optivo\Business;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OptivoSubscribeRequestTransfer;
use Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer;
use Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer;

interface OptivoFacadeInterface
{
//    /**
//     * Specification:
//     * - Receives the fully configured MailTransfer
//     * - Sends the mail
//     *
//     * @api
//     *
//     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
//     *
//     * @return void
//     */
//    public function sendMail(MailTransfer $mailTransfer);
//
//    /**
//     * @param \Generated\Shared\Transfer\OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer
//     *
//     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
//     */
//    public function sendSubscribeRequest(OptivoSubscribeRequestTransfer $optivoSubscribeRequestTransfer);
//
//    /**
//     * @param \Generated\Shared\Transfer\OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer
//     *
//     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
//     */
//    public function sendUnsubscribeRequest(OptivoUnsubscribeRequestTransfer $optivoUnsubscribeRequestTransfer);
//
//    /**
//     * @param \Generated\Shared\Transfer\OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer
//     *
//     * @return \Generated\Shared\Transfer\OptivoResponseTransfer
//     */
//    public function sendTransactionalMailRequest(OptivoTransactionalMailRequestTransfer $optivoTransactionalMailRequestTransfer);

    /**
     * Specification:
     *  - Handle customer registration event. It uses CustomerTransfer as the param
     * which has been got from PostCustomerRegistrationPluginInterface
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handleCustomerRegistrationEvent(CustomerTransfer $customerTransfer): void;

    /**
     * Specification:
     *  - Handle customer reset password event. It uses CustomerTransfer as the param
     * which has been got from MailerTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function handleCustomerResetPasswordEvent(CustomerTransfer $customerTransfer): void;

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
}
