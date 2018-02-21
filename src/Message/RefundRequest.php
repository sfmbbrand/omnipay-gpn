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
 * Class RefundRequest
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class RefundRequest extends PurchaseAuthorize {
	/**
	 * RefundRequest constructor.
	 *
	 * @param Omnipay\Common\Http\Client              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->cmd = 760;
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->cmd . (string) $this->getGatewayTransactionId() . (string) $this->getAmount() . $this->getApiKey());
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();

		$data->addChild('gatetransid', $this->getGatewayTransactionId());
		$data->addChild('amount', $this->getAmount());
		$data->addChild('reason', $this->getReason());

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

	/**
	 * @param string $reason
	 */
	public function setReason($reason) {
		$this->setParameter('reason', $reason);
	}

	/**
	 * @return string
	 */
	private function getReason() {
		return $this->getParameter('reason');
	}
}
