<?php

/**
 *
 * MailChimp For Magento
 *
 * Class Ebizmarts_MailChimp_Helper_Curl
 * @category  Ebizmarts_MailChimp
 * @author    Ebizmarts Team <info@ebizmarts.com>
 * @copyright Ebizmarts (http://ebizmarts.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @date:     9/5/19 3:55 PM
 * @file:     Curl.php
 */

class Ebizmarts_MailChimp_Helper_Curl extends Mage_Core_Helper_Abstract
{
    /**
     * @param array $options
     * @return array An array with...
     */
    public function curlExec($url, $httpMethod, $curlOptions = array(), $params = array())
    {
        if ($url === false) {
            return array('error' => "It's required an URL to be requested with any http method.");
        }

        if ($httpMethod === false) {
            return array('error' => "It's required to specify the HTTP method.");
        }

        $curlError = null;
        $curl = new Mage_HTTP_Client_Curl();

        foreach ($curlOptions as $key => $value) {
            if (isset($value)) {
                $curl->setOption($key, $value);
            }
        }

        $curlResult = null;

        try {
            if ($httpMethod == Zend_Http_Client::GET) {
                $curl->get($url);
            } elseif ($httpMethod == Zend_Http_Client::POST) {
                $curl->post($url, $params);
            }

            $curlResult = $curl->getBody();
        } catch (Exception $e) {
            $curlError = $e->getMessage();
        }

        return array('response' => $curlResult, 'error' => $curlError);
    }
}
