<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Episerver;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface EpiserverConstants
{
    /**
     * Specification:
     * - Provides associative array of mailing id per mail type.
     *
     * @api
     */
    public const CONFIGURATION_DEFAULT_MAILING_ID_LIST = 'EPISERVER:CONFIGURATION_DEFAULT_MAILING_ID_LIST';

    /**
     * Specification:
     * - Base url used for sending api requests.
     *
     * @api
     */
    public const REQUEST_BASE_URL = 'EPISERVER:REQUEST_BASE_URL';

    /**
     * Specification:
     * - Timeout value in between HTTP requests.
     *
     * @api
     */
    public const REQUEST_TIMEOUT = 'EPISERVER:REQUEST_TIMEOUT';

    /**
     * Specification:
     * - Authorization code for oder list requests.
     *
     * @api
     */
    public const ORDER_LIST_AUTHORIZATION_CODE = 'EPISERVER:ORDER_LIST_AUTHORIZATION_CODE';

    /**
     * Specification:
     * - Authorization code for customer list requests.
     *
     * @api
     */
    public const CUSTOMER_LIST_AUTHORIZATION_CODE = 'EPISERVER:CUSTOMER_LIST_AUTHORIZATION_CODE';

    /**
     * Specification:
     * - New order mailing id, used in payload.
     *
     * @api
     */
    public const ORDER_NEW_MAILING_ID = 'EPISERVER:EVENT_ORDER_NEW';

    /**
     * Specification:
     * - Order shipping confirmation mailing id, used in payload.
     *
     * @api
     */
    public const ORDER_SHIPPING_CONFIRMATION_MAILING_ID = 'EPISERVER:EVENT_ORDER_SHIPPING_CONFIRMATION';

    /**
     * Specification:
     * - Order canceled mailing id, used in payload.
     *
     * @api
     */
    public const ORDER_CANCELLED_MAILING_ID = 'EPISERVER:EVENT_ORDER_CANCELLED';

    /**
     * Specification:
     * - Order payment is not recevied mailing id, used in payload.
     *
     * @api
     */
    public const ORDER_PAYMENT_IS_NOT_RECEIVED_MAILING_ID = 'EPISERVER:EVENT_ORDER_PAYMENT_IS_NOT_RECEIVED';

    /**
     * Specification:
     * - Authorization code for newsletter requests.
     *
     * @api
     */
    public const CUSTOMER_NEWSLETTER_AUTHORIZATION_CODE = 'EPISERVER:CUSTOMER_NEWSLETTER_AUTHORIZATION_CODE';
}
