<?php
/**
 * User: Rolando Toledo
 * Email: rtf@gpndata.com
 * Date: 10/13/15
 * Time: 1:34 PM
 *
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Message;

use Omnipay\Common\Http\Client;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ManualRebill
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class ManualRebill extends PurchaseAuthorize {
	/**
	 * ManualRebill constructor.
	 *
	 * @param \Omnipay\Common\Http\Client              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->action = 756;
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->action . (string) $this->getGatewayTransactionId() . (string) $this->getTransactionId() . $this->getApiKey());
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();

		$data->addChild('gatetransid', $this->getGatewayTransactionId());
		$data->addChild('rebillsecret', $this->getRebillSecret());

		$transaction = $data->addChild('transaction');

		if (!is_null($this->getAmount())) {
			$transaction->addChild('amount', $this->getAmount());
		}

		$transaction->addChild('merchanttransid', $this->getTransactionId());

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
	public function getRebillSecret() {
		return $this->getParameter('rebillSecret');
	}

	/**
	 * @param string $gatewayTransactionId
	 */
	public function setGatewayTransactionId($gatewayTransactionId) {
		$this->setParameter('gatewayTransactionId', $gatewayTransactionId);
	}

	/**
	 * @param string $rebillSecret
	 */
	public function setRebillSecret($rebillSecret) {
		$this->setParameter('rebillSecret', $rebillSecret);
	}
}
