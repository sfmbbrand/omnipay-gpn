<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Message;

use Guzzle\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateRebill
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class UpdateRebill extends PurchaseAuthorize {
	/**
	 * UpdateRebill constructor.
	 *
	 * @param \Guzzle\Http\ClientInterface              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(ClientInterface $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->action = 755;
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->action . (string) $this->getTransactionId() . (string) $this->getGatewayTransactionId() . $this->getApiKey());
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();

		$data->addChild('merchanttransid', $this->getTransactionId());
		$data->addChild('gatetransid', $this->getGatewayTransactionId());

		if (!is_null($this->getAmount())) {
			$data->addChild('amount', $this->getAmount());
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
	 * @param string $gatewayTransactionId
	 */
	public function setGatewayTransactionId($gatewayTransactionId) {
		$this->setParameter('gatewayTransactionId', $gatewayTransactionId);
	}
}
