<?php

namespace App\Packages\BBVA\Exceptions;

use Exception;

class BBVAException extends Exception
{
    /**
     * BBVA Error Description
     *
     * @var string
     */
    protected $description;

    /**
     * BBVA Error Code
     *
     * @var int
     */
    protected $error_code;

    /**
     * BBVA Request Category
     *
     * @var string
     */
    protected $category;

    /**
     * HTTP Code
     *
     * @var int
     */
    protected $http_code;

    /**
     * BBVA Request ID
     *
     * @var string
     */
    protected $request_id;

    /**
     * BBVA Fraud Rules
     *
     * @var array
     */
    protected $fraud_rules;

    /**
     * BBVA Exception constructor
     *
     * @param string $message
     * @param integer $error_code
     * @param string $category
     * @param string $request_id
     * @param integer $http_code
     * @param mixed $fraud_rules
     */
    public function __construct($message = null, $error_code = null, $category = null, $request_id = null, $http_code = null, $fraud_rules = null)
    {
        parent::__construct($message, $error_code);
        $this->description = $message;
        $this->error_code = isset($error_code) ? $error_code : 0;
        $this->category = isset($category) ? $category : '';
        $this->http_code = isset($http_code) ? $http_code : 0;
        $this->request_id = isset($request_id) ? $request_id : '';
        $this->fraud_rules = isset($fraud_rules) ? $fraud_rules : array();
    }

    /**
     * Get description attribute
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get error code attribute
     *
     * @return integer
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * Get category attribute
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get HTTP code attribute
     *
     * @return integer
     */
    public function getHttpCode()
    {
        return $this->http_code;
    }

    /**
     * Get request id attribute
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Get fraud rules attribute
     *
     * @return mixed
     */
    public function getFraudRules()
    {
        return $this->fraud_rules;
    }
}
