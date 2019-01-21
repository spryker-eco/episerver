<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Order;

use ArrayObject;
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
     *
     * @return \Generated\Shared\Transfer\OptivoRequestTransfer
     */
    public function map(OrderTransfer $orderTransfer): OptivoRequestTransfer
    {
        $requestTransfer = new OptivoRequestTransfer();

        $requestTransfer->setAuthorizationCode($this->config->getOrderListAuthCode());
        $requestTransfer->setOperationType($this->config->getOperationTypeSendTransactionEmail());
        $requestTransfer->setPayload($this->getPayload($orderTransfer));

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return array
     */
    protected function getPayload(OrderTransfer $orderTransfer): array
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
            static::KEY_ORDER_SUBTOTAL => $orderTransfer->getTotals()->getSubtotal(),
            static::KEY_ORDER_DISCOUNT => $orderTransfer->getTotals()->getDiscountTotal(),
            static::KEY_ORDER_TAX => $orderTransfer->getTotals()->getTaxTotal()->getAmount(),
            static::KEY_ORDER_GRAND_TOTAL => $orderTransfer->getTotals()->getGrandTotal(),
            static::KEY_ORDER_TOTAL_DELIVERY_COSTS => $this->getDeliveryCosts($orderTransfer->getExpenses()),
            static::KEY_ORDER_TOTAL_PAYMENT_COSTS => $this->getPaymentMethodsTotal($orderTransfer->getPayments()),
        ];

        return $payload;
    }

    /**
     * @return string
     */
    abstract protected function getMailingId(): string;

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\PaymentTransfer[] $methods
     *
     * @return int
     */
    protected function getPaymentMethodsTotal(ArrayObject $methods): int
    {
        $sum = 0;

        foreach ($methods as $method) {
            $sum += $method->getAmount();
        }

        return $sum;
    }

    /**
     * @param int $value
     *
     * @return string
     */
    protected function getFormattedPriceFromInt(int $value): string
    {
        $moneyTransfer = $this->moneyFacade->fromInteger($value);

        return $this->moneyFacade->formatWithSymbol($moneyTransfer);
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\ExpenseTransfer[] $expenses
     *
     * @return int
     */
    protected function getDeliveryCosts(ArrayObject $expenses): int
    {
        foreach ($expenses as $expense) {
            if ($expense->getType() === ShipmentConstants::SHIPMENT_EXPENSE_TYPE) {
                return $expense->getSumGrossPrice();
            }
        }

        return 0;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return string
     */
    protected function getLocale(CustomerTransfer $customerTransfer): string
    {
        if ($customerTransfer->getLocale() !== null) {
            return $customerTransfer->getLocale()->getLocaleName();
        }

        return $this->localeFacade->getCurrentLocaleName();
    }
}
