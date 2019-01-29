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
     * - Receives the IdSalesOrder
     * - Sends the request to Episerver API
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
     * - Receives the IdSalesOrder
     * - Sends the request to Episerver API
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
     * - Receives the IdSalesOrder
     * - Sends the request to Episerver API
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
     * - Receives the IdSalesOrder
     * - Sends the request to Episerver API
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
     * - Receives the fully configured MailTransfer
     * - Sends the request to Episerver API
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
     * - Receives the fully configured MailTransfer
     * - Sends the request to Episerver API
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function mailNewsletterSubscription(MailTransfer $mailTransfer): void;
}
