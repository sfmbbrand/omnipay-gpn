<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Message;

use Omnipay\Common\Http\Client;
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
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->cmd = 708;
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->cmd . (string) $this->getGatewayTransactionId() . (string) $this->getMerchantTransactionId() . $this->getApiKey());
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
