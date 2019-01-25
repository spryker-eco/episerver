<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Optivo\Business\OptivoBusinessFactory getFactory()
 */
class OptivoFacade extends AbstractFacade implements OptivoFacadeInterface
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
    public function handleNewOrderEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createNewOrderEventHandler()
            ->handle($idSalesOrder);
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
    public function handleOrderCanceledEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createOrderCancelledEventHandler()
            ->handle($idSalesOrder);
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
    public function handlePaymentNotReceivedEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createPaymentNotReceivedEventHandler()
            ->handle($idSalesOrder);
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
    public function handleShippingConfirmationEvent(int $idSalesOrder): void
    {
        $this->getFactory()
            ->createShippingConfirmationEventHandler()
            ->handle($idSalesOrder);
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
    public function handleCustomerEvent(MailTransfer $mailTransfer): void
    {
        $this->getFactory()
            ->createCustomerEventHandler()
            ->handle($mailTransfer);
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
    public function handleNewsletterSubscription(MailTransfer $mailTransfer): void
    {
        $this->getFactory()
            ->createNewsletterSubscriptionEventHandler()
            ->handle($mailTransfer);
    }
}
