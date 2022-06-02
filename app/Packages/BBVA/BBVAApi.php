<?php

namespace App\Packages\BBVA;

use Illuminate\Support\Facades\Log;
use App\Packages\BBVA\Exceptions\BBVAException;

class BBVAApi
{
    private static $instance;

    private $apiKey;

    private function __construct()
    {
        $this->apiKey = '';
    }

    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function _request($method, $url, $params)
    {
        $id = BBVA::getId();

        if (!$id) {
            throw new BBVAException("Empty or no Merchant ID provided");
        } elseif (!preg_match('/^[a-z0-9]{20}$/i', $id)) {
            throw new BBVAException("Invalid Merchant ID '" . $id . "'");
        }

        $this->apiKey = BBVA::getApiKey();

        $uri = BBVA::getEndpointUrl();

        if (!$uri) {
            throw new BBVAException("No API endpoint set");
        }

        $uri .= '/' . $id . $url;
        $headers = ['User-Agent: BbvaPhp/v1'];

        list($body, $code) = $this->_curlRequest($method, $uri, $headers, $params, $this->apiKey);
        return $this->interpretResponse($body, $code);
    }

    private function _curlRequest($method, $url, $headers, $params, $auth = null)
    {
        $opts = [];

        if (!is_array($headers)) {
            $headers = [];
        }

        if ($method == 'get') {
            $opts[CURLOPT_HTTPGET] = 1;

            if (count($params) > 0) {
                $encoded = $this->encodeToQueryString($params);
                $url = $url . '?' . $encoded;
            }
        } elseif ($method == 'post') {
            $data = $this->encodeToJson($params);
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $data;
            array_push($headers, 'Content-Type: application/json');
            array_push($headers, 'Content-Length: ' . strlen($data));
        } elseif ($method == 'put') {
            # code...
        } elseif ($method == 'delete') {
            # code...
        } else {
            throw new BBVAException("Invalid request method '" . strtoupper($method) . "'");
        }

        $opts[CURLOPT_URL] = $url;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = 30;
        $opts[CURLOPT_TIMEOUT] = 80;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_SSL_VERIFYPEER] = true;

        if ($auth) {
            $opts[CURLOPT_USERPWD] = $auth . ':';
        }

        $curl = curl_init();
        curl_setopt_array($curl, $opts);

        $body = curl_exec($curl);
        $errCode = curl_errno($curl);

        /**
         * if request fails because bad certificate verification, then
         * retry the request by using the CA certificates bundle
         * CURLE_SSL_CACERT || CURLE_SSL_CACERT_BADFILE
         */
        if ($errCode == 60 || $errCode == 77) {
            curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
            $body = curl_exec($curl);
        }

        if ($body === false) {
            Log::error("cURL request error: " . curl_errno($curl));

            $message = curl_error($curl);
            $errCode = curl_errno($curl);
            curl_close($curl);

            $this->handleCurlError($errCode, $message);
        }

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (mb_detect_encoding($body, 'UTF-8', true) != 'UTF-8') {
            Log::warning("Response body is not an UTF-8 string");
        }

        Log::debug("cURL body: " . $body);
        Log::debug("cURL code: " . $code);

        return [$body, $code];
    }

    private function encodeToQueryString($array, $prefix = null)
    {
        if (!is_array($array)) {
            return $array;
        }

        $query = [];

        foreach ($array as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            if ($prefix && $key && !is_int($key)) {
                $key = $prefix . "[" . $key . "]";
            } elseif ($prefix) {
                $key = $prefix . "[]";
            }

            if (is_array($value)) {
                $query[] = $this->encodeToQueryString($value, $key, true);
            } else {
                $query[] = urlencode($key) . "=" . urlencode($value);
            }
        }

        $string = implode("&", $query);

        Log::debug("Query string: " . $string);

        return $string;
    }

    private function encodeToJson($array)
    {
        $encoded = json_encode($array);

        if (mb_detect_encoding($encoded, "UTF-8", true) != "UTF-8") {
            $encoded = utf8_encode($encoded);
        }

        return $encoded;
    }

    private function interpretResponse($body, $code)
    {
        try {
            if (!empty($body)) {
                $response = json_decode($body, true);
            } else {
                $response = [];
            }
        } catch (\Exception $e) {
            throw new BBVAException("Invalid response: " . $body, $code);
        }

        if ($code < 200 || $code >= 300) {
            Log::error("Request finished with HTTP code " . $code);
            $this->handleRequestError($body, $code, $response);
            return [];
        }

        return $response;
    }

    private function handleRequestError($body, $code, $response)
    {
        if (!is_array($response) || !isset($response['error_code'])) {
            throw new BBVAException("Invalid response body recived from BBVA API Server");
        }

        $message = isset($response['description']) ? $response['description'] : "No description";
        $error = $response['error_code'];
        $category = isset($response['category']) ? $response['category'] : null;
        $request_id = isset($response['request_id']) ? $response['request_id'] : null;
        $fraud_rules = isset($response['fraud_rules']) ? $response['fraud_rules'] : null;

        switch ($code) {
            # Unauthorized - Forbidden
            case 401:
            case 403:
                throw new BBVAException($message, $error, $category, $request_id, $code, $fraud_rules);
                break;
            # Bad Request - Not Found - Request Entity too large - Internal Server Error - Service Unavailable
            case 400:
            case 404:
            case 413:
            case 422:
            case 500:
            case 503:
                throw new BBVAException($message, $error, $category, $request_id, $code, $fraud_rules);
                break;
            # Payment Required - Conflict - Preconditon Failed - Unprocessable Entity - Locked
            case 402:
            case 409:
            case 412:
            case 423:
                throw new BBVAException($message, $error, $category, $request_id, $code, $fraud_rules);
                break;
            # Not Found
            default:
                throw new BBVAException($message, $error, $category, $request_id, $code, $fraud_rules);
                break;
        }
    }

    private static function handleCurlError($code, $message)
    {
        switch ($code) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $message = 'Could not connect to BBVA. Please check your internet connection and try again';
                break;
            default:
                $message = 'Unexpected error connecting to BBVA';
                break;
        }

        $message .= " (Network error " . $code . ")";

        Log::critical($message);

        throw new BBVAException($message);
    }

    public static function request($method, $url, $params = null)
    {
        Log::info("BBVAApi @request " . $url);

        if (!$params) {
            $params = [];
        }

        $method = strtolower($method);

        if (!in_array($method, ['get', 'post', 'delete', 'put'])) {
            throw new BBVAException("Invalid request method '" . $method . "'");
        }

        $connector = self::getInstance();

        return $connector->_request($method, $url, $params);
    }
}
