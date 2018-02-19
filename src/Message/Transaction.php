<?php
/**
 * User: Rolando Toledo
 * Email: rtf@gpndata.com
 * Date: 10/13/15
 * Time: 12:37 PM
 *
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Message;

use Guzzle\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Transaction
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class Transaction extends PurchaseAuthorize {
	/**
	 * Transaction constructor.
	 *
	 * @param \Guzzle\Http\ClientInterface              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(\Guzzle\Http\ClientInterface $httpClient, \Symfony\Component\HttpFoundation\Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->action = 708;
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->action . (string) $this->getGatewayTransactionId() . (string) $this->getMerchantTransactionId() . $this->getApiKey());
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();

		if (!is_null($this->getGatewayTransactionId())) {
			$data->addChild('gatetransid', (string) $this->getGatewayTransactionId());
		}

		if (!is_null($this->getMerchantTransactionId())) {
			$data->addChild('merchanttransid', (string) $this->getMerchantTransactionId());
		}

		return $data;
	}

	/**
	 * @return string
	 */
	public function getGatewayTransactionId() {
		return $this->getParameter('gatewayTransactionId');
	}

	/**
	 * @return string
	 */
	public function getMerchantTransactionId() {
		return $this->getParameter('merchantTransactionId');
	}

	/**
	 * @param string $gatewayTransactionId
	 */
	public function setGatewayTransactionId($gatewayTransactionId) {
		$this->setParameter('gatewayTransactionId', $gatewayTransactionId);
	}

	/**
	 * @param string $merchantTransactionId
	 */
	public function setMerchantTransactionId($merchantTransactionId) {
		$this->setParameter('merchantTransactionId', $merchantTransactionId);
	}
}
