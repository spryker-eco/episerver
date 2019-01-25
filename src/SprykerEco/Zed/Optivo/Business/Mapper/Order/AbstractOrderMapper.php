<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Order;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Shared\Shipment\ShipmentConstants;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractOrderMapper implements OrderMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Optivo\OptivoConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface
     */
    protected $moneyFacade;

    /**
     * @var \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Optivo\OptivoConfig $config
     * @param \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface $moneyFacade
     * @param \SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface $localeFacade
     */
    public function __construct(
        OptivoConfig $config,
        OptivoToMoneyFacadeInterface $moneyFacade,
        OptivoToLocaleFacadeInterface $localeFacade
    ) {
        $this->config = $config;
        $this->moneyFacade = $moneyFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\OptivoRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function mapOrderTransferToOptivoRequestTransfer(OrderTransfer $orderTransfer, OptivoRequestTransfer $requestTransfer): OptivoRequestTransfer
    {
        $requestTransfer->setAuthorizationCode($this->config->getOrderListAuthorizationCode());
        $requestTransfer->setOperationType($this->config->getOperationSendTransactionEmail());
        $requestTransfer->setPayload($this->buildPayload($orderTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return array
     */
    protected function buildPayload(OrderTransfer $orderTransfer): array
    {
        $locale = $this->getLocale($orderTransfer->getCustomer());

        $payload = [
            static::KEY_MAILING_ID => $this->getMailingId(),
            static::KEY_EMAIL => $orderTransfer->getEmail(),
            static::KEY_SALUTATION => $orderTransfer->getSalutation(),
            static::KEY_FIRSTNAME => $orderTransfer->getFirstName(),
            static::KEY_LASTNAME => $orderTransfer->getLastName(),
            static::KEY_SPRYKER_ID => $orderTransfer->getFkCustomer(),
            static::KEY_CUSTOMER_SHOP_LOCALE => $locale,
            static::KEY_CUSTOMER_SHOP_URL => $this->config->getHostYves(),
            static::KEY_CUSTOMER_LOGIN_URL => $this->config->getHostYves() . static::URL_LOGIN,
            static::KEY_CUSTOMER_RESET_LINK => '',
            static::KEY_LANGUAGE => $locale,
            static::KEY_ORDER_NUMBER => $orderTransfer->getOrderReference(),
            static::KEY_ORDER_COMMENT => $orderTransfer->getCartNote(),
            static::KEY_ORDER_ORDERDATE => $orderTransfer->getCreatedAt(),
            static::KEY_ORDER_TOTAL_DELIVERY_COSTS => $this->calculateDeliveryCosts($orderTransfer),
            static::KEY_ORDER_TOTAL_PAYMENT_COSTS => $this->calculatePaymentMethodsTotal($orderTransfer),
        ];

        $totalsTransfer = $orderTransfer->getTotals();

        if ($totalsTransfer !== null) {
            $payload += [
                static::KEY_ORDER_SUBTOTAL => $totalsTransfer->getSubtotal(),
                static::KEY_ORDER_DISCOUNT => $totalsTransfer->getDiscountTotal(),
                static::KEY_ORDER_GRAND_TOTAL => $totalsTransfer->getGrandTotal(),
            ];
        }

        if ($totalsTransfer !== null && $totalsTransfer->getTaxTotal() !== null) {
            $payload[static::KEY_ORDER_TAX] = $totalsTransfer->getTaxTotal()->getAmount();
        }

        return $payload;
    }

    /**
     * @return string
     */
    abstract protected function getMailingId(): string;

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return int
     */
    protected function calculatePaymentMethodsTotal(OrderTransfer $orderTransfer): int
    {
        $sum = 0;

        $methods = $orderTransfer->getPayments();

        foreach ($methods as $method) {
            $sum += $method->getAmount();
        }

        return $sum;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return int
     */
    protected function calculateDeliveryCosts(OrderTransfer $orderTransfer): int
    {
        $expenses = $orderTransfer->getExpenses();
        foreach ($expenses as $expense) {
            if ($expense->getType() === ShipmentConstants::SHIPMENT_EXPENSE_TYPE) {
                if ($expense->getSumPriceToPayAggregation() === null) {
                    return 0;
                }

                return $expense->getSumPriceToPayAggregation();
            }
        }

        return 0;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return string
     */
    protected function getLocale(?CustomerTransfer $customerTransfer): string
    {
        $isCustomerLocaleName = $customerTransfer !== null &&
            $customerTransfer->getLocale() !== null &&
            $customerTransfer->getLocale()->getLocaleName() !== null;

        if ($isCustomerLocaleName) {
            return $customerTransfer->getLocale()->getLocaleName();
        }

        return (string)$this->localeFacade->getCurrentLocaleName();
    }
}
