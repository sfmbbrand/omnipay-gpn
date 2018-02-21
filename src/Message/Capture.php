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
 * Class Capture
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class Capture extends PurchaseAuthorize {
	/**
	 * Capture constructor.
	 *
	 * @param \Omnipay\Common\Http\Client              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->cmd = 701;
	}

	/**
	 * @return string
	 */
	public function getCarrier() {
		return $this->getParameter('carrier');
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1(
			$this->getApiUser() .
			$this->getApiPassword() .
			(string) $this->cmd .
			(string) $this->getGateTransId() .
			$this->getApiKey()
		);
	}

	/**
	 * Get the raw data array for this message. The format of this varies from gateway to
	 * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	 *
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();
		$data->addChild('gatetransid', $this->getGateTransId());

		if (!is_null($this->getAmount())) {
			$data->addChild('amount', $this->getAmount());
		}

		if (!is_null($this->getCarrier())) {
			$data->addChild('carrier', $this->getCarrier());
		}

		if (!is_null($this->getTrackingNumber())) {
			$data->addChild('trackingnumber', $this->getTrackingNumber());
		}

		return $data;
	}

	/**
	 * @return string
	 */
	public function getGateTransId() {
		return $this->getParameter('gateTransId');
	}

	/**
	 * @return string
	 */
	public function getTrackingNumber() {
		return $this->getParameter('trackingNumber');
	}

	/**
	 * @param string $carrier
	 */
	public function setCarrier($carrier) {
		$this->setParameter('carrier', $carrier);
	}

	/**
	 * @param string $gateTransId
	 */
	public function setGateTransId($gateTransId) {
		$this->setParameter('gateTransId', $gateTransId);
	}

	/**
	 * @param string $tranckingNumber
	 */
	public function setTrackingNumber($tranckingNumber) {
		$this->setParameter('trackingNumber', $tranckingNumber);
	}
}
