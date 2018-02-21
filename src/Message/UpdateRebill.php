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
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->cmd = 755;
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->cmd . (string) $this->getTransactionId() . (string) $this->getGatewayTransactionId() . $this->getApiKey());
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();

		$data->addChild('merchanttransid', $this->getTransactionId());
		$data->addChild('gatetransid', $this->getGatewayTransactionId());
		$data->addChild('action', $this->getAction());

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

	/**
	 * @return string
	 */
	public function getAction() {
		return $this->getParameter('action');
	}

	/**
	 * @param string $action
	 */
	public function setAction($action) {
		$this->setParameter('action', $action);
	}
}
