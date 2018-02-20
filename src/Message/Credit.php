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
 * Class Credit
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class Credit extends PurchaseAuthorize {
	/**
	 * Credit constructor.
	 *
	 * @param \Omnipay\Common\Http\Client              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->action = 720;
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getBillingData() {
		$data        = $this->getBaseData();
		$transaction = $data->addChild('transaction');
		$transaction->addChild('amount', $this->getAmount());
		// A custom field can be used to pass over the merchant site transaction ID.
		$transaction->addChild(static::TRANSACTION_ID_PARAM, $this->getTransactionId());
		$data->addChild('previoustransactionid', $this->getPTID());
		$transaction->addChild('curcode', $this->getCurrency());
		$transaction->addChild('description', $this->getDescription());
		$customer = $data->addChild('customer');
		if ($fn = $this->getFirstname()) {
			$customer->addChild('firstname', $fn);
		}
		if ($ln = $this->getLastname()) {
			$customer->addChild('lastname', $ln);
		}
		if ($email = $this->getEmail()) {
			$customer->addChild('email', $email);
		}
		if ($account = $this->getAccountId()) {
			$customer->addChild('accountid', $account);
		}
		if ($ip = $this->getClientIp()) {
			$customer->addChild('ipaddress', $ip);
		}
		if ($city = $this->getCity()) {
			$customer->addChild('city', $city);
		}
		if ($country = $this->getCountry()) {
			$customer->addChild('countryiso', $country);
		}
		if ($card = $this->getCard()) {
			// customer shipping details
			$creditCard = $data->addChild('creditcard');
			$creditCard->addChild('ccnumber', $card->getNumber());
		}

		return $data;
	}

	/**
	 * @return string
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	public function getCheckSum() {
		$cc = $this->getCard();
		$cc = isset($cc) ? $cc->getNumber() : '';
		return sha1(
			$this->getApiUser() .
			$this->getApiPassword() .
			(string) $this->action .
			(string) $this->getTransactionId() .
			(string) $this->getAmount() .
			$this->getCurrency() .
			$cc .
			$this->getPTID() .
			$this->getApiKey()
		);
	}

	/**
	 * @return mixed
	 */
	public function getCity() {
		return $this->getParameter('city');
	}

	/**
	 * @return mixed
	 */
	public function getCountry() {
		return $this->getParameter('country');
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData() {
		return $this->getBillingData();
	}

	/**
	 * @return mixed
	 */
	public function getPTID() {
		return $this->getParameter('ptid');
	}

	/**
	 * @param $city
	 */
	public function setCity($city) {
		$this->setParameter('city', $city);
	}

	/**
	 * @param $country
	 */
	public function setCountry($country) {
		$this->setParameter('country', $country);
	}

	/**
	 * @param $transID
	 */
	public function setPTID($transID) {
		$this->setParameter('ptid', $transID);
	}
}
