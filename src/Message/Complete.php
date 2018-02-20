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
 * Class Complete
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class Complete extends PurchaseAuthorize {
	/**
	 * Complete constructor.
	 *
	 * @param \Omnipay\Common\Http\Client              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->action = 705;
	}

	/**
	 * @return string
	 */
	public function getAuthorizeACSRes() {
		return $this->getParameter('authorizeACSRes');
	}

	/**
	 * @return string
	 */
	public function getAuthorizeMD() {
		return $this->getParameter('authorizeMD');
	}

	/**
	 * @return string
	 */
	public function getAuthorizeType() {
		return $this->getParameter('authorizeType');
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1(
			$this->getApiUser() .
			$this->getApiPassword() .
			(string) $this->action .
			$this->getAuthorizeType() .
			$this->getAuthorizeMD() .
			$this->getApiKey()
		);
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		$data = $this->getBaseData();

		$auth = $data->addChild('auth');
		$auth->addChild('type', $this->getAuthorizeType());
		$auth->addChild('ACSRes', $this->getAuthorizeACSRes());
		$auth->addChild('MD', $this->getAuthorizeMD());

		return $data;
	}

	/**
	 * @param string $authorizeACSRes
	 */
	public function setAuthorizeACSRes($authorizeACSRes) {
		$this->setParameter('authorizeACSRes', $authorizeACSRes);
	}

	/**
	 * @param string $authorizeMD
	 */
	public function setAuthorizeMD($authorizeMD) {
		$this->setParameter('authorizeMD', $authorizeMD);
	}

	/**
	 * @param string $authorizeType
	 */
	public function setAuthorizeType($authorizeType) {
		$this->setParameter('authorizeType', $authorizeType);
	}
}
