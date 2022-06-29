<?php

namespace App\Packages\BBVA;

use App\Packages\BBVA\BBVAApi;
use App\Packages\BBVA\BBVAApiConsole;
use App\Packages\BBVA\Exceptions\BBVAException;

class BBVA
{
    /**
     * BBVA api instance
     *
     * @var mixed
     */
    private static $instance = null;

    /**
     * Api merchantID
     *
     * @var string
     */
    private static $id = '';

    /**
     * Api key string
     *
     * @var string
     */
    private static $apiKey = '';

    /**
     * BBVA production API endpoint
     *
     * @var string
     */
    private static $apiEndpoint = 'https://api.ecommercebbva.com/v1';

    /**
     * BBVA sandbox API endpoint
     *
     * @var string
     */
    private static $apiSandboxEndpoint = 'https://sand-api.ecommercebbva.com/v1';

    /**
     * Environment mode
     *
     * @var boolean
     */
    private static $sandboxMode = true;

    /**
     * BBVA library constructor
     */
    public function __construct()
    {
        if (config('bbva.merchant_id') != '') {
            self::setId(config('bbva.merchant_id'));
        }

        if (config('bbva.private_key') != '') {
            self::setApiKey(config('bbva.private_key'));
        }

        $this->setProductionMode(config('bbva.production'));
    }

    /**
     * Validates the merchantId
     *
     * @param string $id
     * @return void
     */
    protected function validateId($id)
    {
        if (!is_string($id) || !preg_match('/^[a-z][a-z0-9]{0,20}$/i', $id)) {
            throw new BBVAException("Invalid ID detected (value '" . $id . "' received, alphanumeric string not longer than 20 characters expected)");

            BBVAApiConsole::warn("[BBVA] Invalid ID detected (value '" . $id . "' received, alphanumeric string not longer than 20 characters expected)");
        }
    }

    /**
     * Create a new charge request
     *
     * @param array $params
     * @return mixed
     */
    public static function charges($params)
    {
        if (!is_array($params)) {
            throw new BBVAException("Invalid parameters type detected (type '" . gettype($params) . "' received, Array expected)");

            BBVAApiConsole::warn("[BBVA] Invalid parameters type detected (type '" . gettype($params) . "' received, Array expected)");
        }

        $charge = BBVAApi::request('POST', '/charges', $params);

        return $charge;
    }

    public static function confirmCharge($transaction, $params)
    {
        if (!is_array($params)) {
            throw new BBVAException("Invalid parameters type detected (type '" . gettype($params) . "' received, Array expected)");

            BBVAApiConsole::warn("[BBVA] Invalid parameters type detected (type '" . gettype($params) . "' received, Array expected)");
        }

        $charge = BBVAApi::request('POST', "/charges/" . $transaction . "/capture", $params);

        return $charge;
    }

    public static function refund($transaction, $params)
    {
        if (!is_array($params)) {
            throw new BBVAException("Invalid parameters type detected (type '" . gettype($params) . "' received, Array expected)");

            BBVAApiConsole::warn("[BBVA] Invalid parameters type detected (type '" . gettype($params) . "' received, Array expected)");
        }

        $refund = BBVAApi::request('POST', '/charges/' . $transaction . '/refund', $params);

        return $refund;
    }

    /**
     * Get Charge
     * Returns the information of a charge generated at any time just by knowing the charge id.
     *
     * @param string $transaction
     * @return array
     */
    public static function getCharge(string $transaction)
    {
        if (!is_string($transaction)) {
            throw new BBVAException("Invalid parameters type detected (type '" . gettype($transaction) . "' received, Array expected)");
            BBVAApiConsole::warn("[BBVA] Invalid parameters type detected (type '" . gettype($transaction) . "' received, Array expected)");
        }

        $charge = BBVAApi::request('GET', "/charges/" . $transaction);

        return $charge;
    }

    /**
     * Set api key
     *
     * @param string $key
     * @return void
     */
    public static function setApiKey($key = '')
    {
        if ($key != '') {
            self::$apiKey = $key;
        }
    }

    /**
     * Get api key
     *
     * @return string
     */
    public static function getApiKey()
    {
        $key = self::$apiKey;
        if (!$key) {
            $key = config('bbva.private_key');
        }
        return $key;
    }

    /**
     * Set merchantId
     *
     * @param string $id
     * @return void
     */
    public static function setId($id = '')
    {
        if ($id != '') {
            self::$id = $id;
        }
    }

    /**
     * Get merchantId
     *
     * @return string
     */
    public static function getId()
    {
        $id = self::$id;
        if (!$id) {
            $id = config('bbva.merchant_id');
        }
        return $id;
    }

    /**
     * Get sandbox mode
     *
     * @return boolean
     */
    public static function getSandboxMode()
    {
        $sandbox = self::$sandboxMode;
        if (config('bbva.production')) {
            $sandbox = (strtoupper(getenv('PRODUCTION_MODE')) == 'FALSE');
        }
        return $sandbox;
    }

    /**
     * Set sandbox environment mode
     *
     * @param boolean $mode
     * @return boolean
     */
    public static function setSandboxMode($mode)
    {
        self::$sandboxMode = $mode ? true : false;
    }

    /**
     * Get the production mode
     *
     * @return boolean
     */
    public static function getProductionMode()
    {
        $sandbox = self::$sandboxMode;
        if (config('bbva.production')) {
            $sandbox = (strtoupper(getenv('PRODUCTION_MODE')) == 'FALSE');
        }
        return !$sandbox;
    }

    /**
     * Set production environment mode
     *
     * @param bolean $mode
     * @return bolean
     */
    public static function setProductionMode($mode)
    {
        self::$sandboxMode = $mode ? false : true;
    }

    /**
     * Get endpoint url
     *
     * @return string
     */
    public static function getEndpointUrl()
    {
        return (self::getSandboxMode() ? self::$apiSandboxEndpoint : self::$apiEndpoint);
    }
}
