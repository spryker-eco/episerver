<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Optivo\Business\Mapper\Order;

use ArrayObject;
use Generated\Shared\Transfer\OptivoRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Shared\Shipment\ShipmentConstants;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToLocaleFacadeInterface;
use SprykerEco\Zed\Optivo\Dependency\Facade\OptivoToMoneyFacadeInterface;
use SprykerEco\Zed\Optivo\OptivoConfig;

abstract class AbstractOrderMapper implements OrderMapperInterface
{
    public const KEY_EMAIL = 'bmRecipientId';
    public const KEY_MAILING_ID = 'bmMailingId';
    public const KEY_SALUTATION = 'salutation';
    public const KEY_FIRSTNAME = 'firstname';
    public const KEY_LASTNAME = 'lastname';
    public const KEY_SPRYKER_ID = 'spryker_id';
    public const KEY_CUSTOMER_SHOP_LOCALE = 'customer_shop_locale';
    public const KEY_CUSTOMER_SHOP_URL = 'customer_shop_url';
    public const KEY_CUSTOMER_LOGIN_URL = 'customer_login_url';
    public const KEY_CUSTOMER_RESET_LINK = 'customer_reset_link';
    public const KEY_LANGUAGE = 'language';
    public const KEY_ORDER_NUMBER = 'order_number';
    public const KEY_ORDER_COMMENT = 'order_comment';
    public const KEY_ORDER_ORDERDATE = 'order_orderdate';
    public const KEY_ORDER_SUBTOTAL = 'order_subtotal';
    public const KEY_ORDER_DISCOUNT = 'order_discount';
    public const KEY_ORDER_TAX = 'order_tax';
    public const KEY_ORDER_GRAND_TOTAL = 'order_grand_total';
    public const KEY_ORDER_TOTAL_DELIVERY_COSTS = 'order_total_delivery_costs';
    public const KEY_ORDER_TOTAL_PAYMENT_COSTS = 'order_total_delivery_costs';

    public const URL_LOGIN = '/login';


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
        $locale = $orderTransfer->getCustomer()->getLocale() ?
            $orderTransfer->getCustomer()->getLocale()->getLocaleName() :
            $this->localeFacade->getCurrentLocaleName();

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
     * @param \ArrayObject $methods
     *
     * @return string
     */
    protected function getPaymentMethodsTotal(ArrayObject $methods): string
    {
        $sum = 0;

        /**
         * @var \Generated\Shared\Transfer\PaymentTransfer $method
         */
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
     * @param \ArrayObject $expenses
     *
     * @return string
     */
    protected function getDeliveryCosts(ArrayObject $expenses): string
    {
        foreach ($expenses as $expense) {
            if ($expense->getType() === ShipmentConstants::SHIPMENT_EXPENSE_TYPE) {
                return$expense->getSumGrossPrice();
            }
        }

        return 0;
    }
}
