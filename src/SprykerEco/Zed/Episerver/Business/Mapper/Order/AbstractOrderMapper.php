<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Episerver\Business\Mapper\Order;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\EpiserverRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Shipment\ShipmentConstants;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface;
use SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToMoneyFacadeInterface;
use SprykerEco\Zed\Episerver\EpiserverConfig;

abstract class AbstractOrderMapper implements OrderMapperInterface
{
    /**
     * @var \SprykerEco\Zed\Episerver\EpiserverConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToMoneyFacadeInterface
     */
    protected $moneyFacade;

    /**
     * @var \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \SprykerEco\Zed\Episerver\EpiserverConfig $config
     * @param \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToMoneyFacadeInterface $moneyFacade
     * @param \SprykerEco\Zed\Episerver\Dependency\Facade\EpiserverToLocaleFacadeInterface $localeFacade
     */
    public function __construct(
        EpiserverConfig $config,
        EpiserverToMoneyFacadeInterface $moneyFacade,
        EpiserverToLocaleFacadeInterface $localeFacade
    ) {
        $this->config = $config;
        $this->moneyFacade = $moneyFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\EpiserverRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\EpiserverRequestTransfer
     */
    public function mapOrderTransferToEpiserverRequestTransfer(OrderTransfer $orderTransfer, EpiserverRequestTransfer $requestTransfer): EpiserverRequestTransfer
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
        if ($customerTransfer !== null &&
            $customerTransfer->getLocale() !== null &&
            $customerTransfer->getLocale()->getLocaleName() !== null) {
            return $this->getLocaleShortName($customerTransfer->getLocale()->getLocaleName());
        }

        return $this->getLocaleShortName($this->localeFacade->getLocaleName());
    }

    /**
     * @param string|null $localeName
     *
     * @return string
     */
    protected function getLocaleShortName(?string $localeName): string
    {
        if ($localeName === null) {
            return '';
        }

        return (string)array_search($localeName, Store::getInstance()->getLocales());
    }
}
