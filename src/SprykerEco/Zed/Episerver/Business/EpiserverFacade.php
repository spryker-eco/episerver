<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Episerver\Business\EpiserverBusinessFactory getFactory()
 */
class EpiserverFacade extends AbstractFacade implements EpiserverFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailNewOrderEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createNewOrderEventMailer()
            ->mail($idSalesOrder);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailOrderCanceledEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createOrderCancelledEventMailer()
            ->mail($idSalesOrder);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailPaymentNotReceivedEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createPaymentNotReceivedEventMailer()
            ->mail($idSalesOrder);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return void
     */
    public function mailShippingConfirmationEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createShippingConfirmationEventMailer()
            ->mail($idSalesOrder);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function mailCustomerEvent(MailTransfer $mailTransfer): void
    {
        $this->getFactory()
            ->createCustomerEventMailer()
            ->mail($mailTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function mailNewsletterSubscription(MailTransfer $mailTransfer): void
    {
        $this->getFactory()
            ->createNewsletterSubscriptionEventMailer()
            ->mail($mailTransfer);
    }
}
