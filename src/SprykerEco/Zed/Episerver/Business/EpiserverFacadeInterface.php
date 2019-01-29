<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business;

use Generated\Shared\Transfer\MailTransfer;

interface EpiserverFacadeInterface
{
    /**
     * Specification:
     * - Retrieves OrderTransfer based on idSalesOrder
     * - Prepares and sends “newOrder” request to Episerver API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailNewOrderEvent(int $idSalesOrder): void;

    /**
     * Specification:
     * - Retrieves OrderTransfer based on idSalesOrder
     * - Prepares and sends “orderCanceled” request to Episerver API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailOrderCanceledEvent(int $idSalesOrder): void;

    /**
     * Specification:
     * - Retrieves OrderTransfer based on idSalesOrder
     * - Prepares and sends “paymentNotReceived” request to Episerver API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailPaymentNotReceivedEvent(int $idSalesOrder): void;

    /**
     * Specification:
     * - Retrieves OrderTransfer based on idSalesOrder
     * - Prepares and sends “shippingConfirmation” request to Episerver API
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailShippingConfirmationEvent(int $idSalesOrder): void;

    /**
     * Specification:
     * - Retrieves OrderTransfer based on the fully configured MailTransfer
     * - Prepares and sends “customerLogin” request to Episerver API
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function mailCustomerEvent(MailTransfer $mailTransfer): void;

    /**
     * Specification:
     * - Retrieves OrderTransfer based on the fully configured MailTransfer
     * - Prepares and sends “customerNewsletterSubscription” request to Episerver API
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function mailNewsletterSubscription(MailTransfer $mailTransfer): void;
}
