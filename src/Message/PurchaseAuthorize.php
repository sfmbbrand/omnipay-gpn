<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 *
 */

namespace Omnipay\GPNDataEurope\Message;

use Omnipay\Common\Http\Client;
use Omnipay\Common\Message\AbstractRequest;
use Symfony\Component\HttpFoundation\Request;

class PurchaseAuthorize extends AbstractRequest {
	const DEV_MODE = 'DEV';

	const PROD_MODE = 'PROD';

	const TEST_MODE = 'TEST';

	const TEST_URL = 'https://txtest.txpmnts.com/api/transaction/';

	const TRANSACTION_ID_PARAM = 'merchanttransid';

	/**
	 * @var int
	 */
	protected $action;

	/**
	 * PurchaseAuthorize constructor.
	 *
	 * @param Omnipay\Common\Http\Client              $httpClient
	 * @param \Symfony\Component\HttpFoundation\Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->cmd = 700;
	}

	/**
	 * @return string
	 */
	public function getAccountId() {
		return $this->getParameter('accountId');
	}

	/**
	 * @return string
	 */
	public function getAction() {
		return $this->getParameter('action');
	}

	/**
	 * @return string
	 */
	public function getApiKey() {
		return $this->getParameter('apiKey');
	}

	/**
	 * @return string
	 */
	public function getApiPassword() {
		return $this->getParameter('apiPassword');
	}

	/**
	 * @return string
	 */
	public function getApiUser() {
		return $this->getParameter('apiUser');
	}

	/**
	 * @return string
	 */
	public function getAuthSid() {
		return $this->getParameter('authSid');
	}

	/**
	 * @return string
	 */
	public function getAuthType() {
		return $this->getParameter('authType') ?: 'Direct';
	}

	/**
	 * @return string
	 */
	public function getBirthDay() {
		return $this->getParameter('birthday');
	}

	/**
	 * @return string
	 */
	public function getBirthMonth() {
		return $this->getParameter('birthMonth');
	}

	/**
	 * @return string
	 */
	public function getBirthYear() {
		return $this->getParameter('birthYear');
	}

	/**
	 * @return string
	 */
	public function getCheckSum() {
		return sha1($this->getApiUser() . $this->getApiPassword() . (string) $this->cmd . (string) $this->getTransactionId() .
			(string) $this->getAmount() . $this->getCurrency() . $this->getCard()->getNumber() . $this->getCard()->getCvv() . $this->getCard()->getName() .
			$this->getApiKey());
	}

	/**
	 * @return string
	 */
	public function getDEV() {
		return $this->getParameter('DEV');
	}

	/**
	 * Get the raw data array for this message. The format of this varies from gateway to
	 * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	 *
	 * @return \SimpleXMLElement
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	public function getData() {
		return $this->getBillingData();
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->getParameter('email');
	}

	/**
	 * @return string
	 */
	public function getFilterValue() {
		return $this->getParameter('filterValue');
	}

	/**
	 * @return string
	 */
	public function getFirstname() {
		return $this->getParameter('firstname');
	}

	/**
	 * @return string
	 */
	public function getFrom() {
		return $this->getParameter('from');
	}

	/**
	 * @return int
	 */
	public function getGracePeriod() {
		return $this->getParameter('gracePeriod');
	}

	/**
	 * @return int
	 */
	public function getInstallmentCount() {
		return $this->getParameter('installmentCount');
	}

	/**
	 * @return string
	 */
	public function getLastname() {
		return $this->getParameter('lastname');
	}

	/**
	 * @return string
	 */
	public function getMerchantSpecification1() {
		return $this->getParameter('merchantSpecification1');
	}

	/**
	 * @return string
	 */
	public function getMerchantSpecification2() {
		return $this->getParameter('merchantSpecification2');
	}

	/**
	 * @return string
	 */
	public function getMerchantSpecification3() {
		return $this->getParameter('merchantSpecification3');
	}

	/**
	 * @return string
	 */
	public function getMerchantSpecification4() {
		return $this->getParameter('merchantSpecification4');
	}

	/**
	 * @return string
	 */
	public function getMerchantSpecification5() {
		return $this->getParameter('merchantSpecification5');
	}

	/**
	 * @return string
	 */
	public function getMode() {
		return $this->getParameter('mode');
	}

	/**
	 * @return string
	 */
	public function getPROD() {
		return $this->getParameter('PROD');
	}

	/**
	 * @return float
	 */
	public function getRebillAmount() {
		return $this->getParameter('rebillAmount');
	}

	/**
	 * @return int
	 */
	public function getRebillCount() {
		return $this->getParameter('rebillCount');
	}

	/**
	 * @return string
	 */
	public function getRebillDescription() {
		return $this->getParameter('rebillDescription');
	}

	/**
	 * @return float
	 */
	public function getRebillFollowupAmount() {
		return $this->getParameter('rebillFollowupAmount');
	}

	/**
	 * @return string
	 */
	public function getRebillFollowupTime() {
		return $this->getParameter('rebillFollowupTime');
	}

	/**
	 * @return string
	 */
	public function getRebillFrequency() {
		return $this->getParameter('rebillFrequency');
	}

	/**
	 * @return string
	 */
	public function getRebillStart() {
		return $this->getParameter('rebillStart');
	}

	/**
	 * @return string
	 */
	public function getSessionId() {
		return $this->getParameter('sessionId');
	}

	/**
	 * @return string
	 */
	public function getStatement() {
		return $this->getParameter('statement');
	}

	/**
	 * @return string
	 */
	public function getTEST() {
		return $this->getParameter('TEST');
	}

	/**
	 * @return string
	 */
	public function getURL() {
		return $this->getParameter($this->getMode());
	}

	/**
	 * @return string
	 */
	public function isRebill() {
		return $this->getParameter('rebill');
	}

	/**
	 * Send the request with specified data
	 *
	 * @param  mixed $data The data to send
	 *
	 * @return \Omnipay\Common\Message\ResponseInterface
	 */
	public function sendData($data) {
		$headers               = ['Content-Type' => 'application/xml; charset=utf-8'];
		$httpResponse          = $this->httpClient->post($this->getURL(), $headers, $data->asXML());
		$content               = new \SimpleXMLElement($httpResponse->getBody()->getContents());
		return $this->response = new Response($this, $content);
	}

	/**
	 * @param string $accountId
	 */
	public function setAccountId($accountId) {
		$this->setParameter('accountId', $accountId);
	}

	/**
	 * @param $action
	 */
	public function setAction($action) {
		$this->setParameter('action', intval($action));
	}

	/**
	 * @param string $apiKey
	 */
	public function setApiKey($apiKey) {
		$this->setParameter('apiKey', $apiKey);
	}

	/**
	 * @param string $apiPassword
	 */
	public function setApiPassword($apiPassword) {
		$this->setParameter('apiPassword', $apiPassword);
	}

	/**
	 * @param string $apiUser
	 */
	public function setApiUser($apiUser) {
		$this->setParameter('apiUser', $apiUser);
	}

	/**
	 * @param string $authSid
	 */
	public function setAuthSid($authSid) {
		$this->setParameter('authSid', $authSid);
	}

	/**
	 * @param string $authType
	 */
	public function setAuthType($authType = 'Direct') {
		$this->setParameter('authType', $authType);
	}

	/**
	 * @param string $birthday
	 */
	public function setBirthDay($birthday) {
		$this->setParameter('birthday', $birthday);
	}

	/**
	 * @param string $birthMonth
	 */
	public function setBirthMonth($birthMonth) {
		$this->setParameter('birthMonth', $birthMonth);
	}

	/**
	 * @param string $birthYear
	 */
	public function setBirthYear($birthYear) {
		$this->setParameter('birthYear', $birthYear);
	}

	/**
	 * @param string $url
	 */
	public function setDEV($url = self::TEST_URL) {
		$this->setParameter(static::DEV_MODE, $url);
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->setParameter('email', $email);
	}

	/**
	 * @param string $value
	 */
	public function setFilterValue($value) {
		$this->setParameter('filterValue', $value);
	}

	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname) {
		$this->setParameter('firstname', $firstname);
	}

	/**
	 * @param string $from
	 */
	public function setFrom($from) {
		$this->setParameter('from', $from);
	}

	/**
	 * @param int $value
	 */
	public function setGracePeriod($value) {
		$this->setParameter('gracePeriod', $value);
	}

	/**
	 * @param int $count
	 */
	public function setInstallmentCount($count) {
		$this->setParameter('installmentCount', $count);
	}

	/**
	 * @param string $lastname
	 */
	public function setLastname($lastname) {
		$this->setParameter('lastname', $lastname);
	}

	/**
	 * @param string $merchantSpecification1
	 */
	public function setMerchantSpecification1($merchantSpecification1) {
		$this->setParameter('merchantSpecification1', $merchantSpecification1);
	}

	/**
	 * @param string $merchantSpecification2
	 */
	public function setMerchantSpecification2($merchantSpecification2) {
		$this->setParameter('merchantSpecification2', $merchantSpecification2);
	}

	/**
	 * @param string $merchantSpecification3
	 */
	public function setMerchantSpecification3($merchantSpecification3) {
		$this->setParameter('merchantSpecification3', $merchantSpecification3);
	}

	/**
	 * @param string $merchantSpecification4
	 */
	public function setMerchantSpecification4($merchantSpecification4) {
		$this->setParameter('merchantSpecification4', $merchantSpecification4);
	}

	/**
	 * @param string $merchantSpecification5
	 */
	public function setMerchantSpecification5($merchantSpecification5) {
		$this->setParameter('merchantSpecification5', $merchantSpecification5);
	}

	/**
	 * @param string $mode
	 */
	public function setMode($mode) {
		$this->setParameter('mode', $mode);
	}

	/**
	 * @param string $url
	 */
	public function setPROD($url = self::TEST_URL) {
		$this->setParameter(static::PROD_MODE, $url);
	}

	/**
	 * @param string $rebill
	 */
	public function setRebill($rebill) {
		$this->setParameter('rebill', $rebill);
	}

	/**
	 * @param float $rebillAmount
	 */
	public function setRebillAmount($rebillAmount) {
		$this->setParameter('rebillAmount', $rebillAmount);
	}

	/**
	 * @param int $rebillCount
	 */
	public function setRebillCount($rebillCount) {
		$this->setParameter('rebillCount', $rebillCount);
	}

	/**
	 * @param string $rebillDescription
	 */
	public function setRebillDescription($rebillDescription) {
		$this->setParameter('rebillDescription', $rebillDescription);
	}

	/**
	 * @param float $rebillFollowupAmount
	 */
	public function setRebillFollowupAmount($rebillFollowupAmount) {
		$this->setParameter('rebillFollowupAmount', $rebillFollowupAmount);
	}

	/**
	 * @param string $rebillFollowupTime
	 */
	public function setRebillFollowupTime($rebillFollowupTime) {
		$this->setParameter('rebillFollowupTime', $rebillFollowupTime);
	}

	/**
	 * @param string $rebillFrequency
	 */
	public function setRebillFrecuency($rebillFrequency) {
		$this->setParameter('rebillFrequency', $rebillFrequency);
	}

	/**
	 * @param string $rebillStart
	 */
	public function setRebillStart($rebillStart) {
		$this->setParameter('rebillStart', $rebillStart);
	}

	/**
	 * @param string $sessionId
	 */
	public function setSessionId($sessionId) {
		$this->setParameter('sessionId', $sessionId);
	}

	/**
	 * @param string $statement
	 */
	public function setStatement($statement) {
		$this->setParameter('statement', $statement);
	}

	/**
	 * @param string $url
	 */
	public function setTEST($url = self::TEST_URL) {
		$this->setParameter(static::TEST_MODE, $url);
	}

	/**
	 * @return \SimpleXMLElement
	 */
	protected function getBaseData() {
		$data = new \SimpleXMLElement('<transaction/>');

		if ($this->getFrom()) {
			if ($this->getFrom() === 'paymentpage') {
				$data = new \SimpleXMLElement('<request/>');
			}

			$data->addAttribute('from', $this->getFrom());
		}

		$data->addChild('apiUser', $this->getApiUser());
		$data->addChild('apiPassword', $this->getApiPassword());
		$data->addChild('apiCmd', $this->cmd);
		$data->addChild('checksum', $this->getCheckSum());

		return $data;
	}

	/**
	 * @return \SimpleXMLElement
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	protected function getBillingData() {
		$data        = $this->getBaseData();
		$transaction = $data->addChild('transaction');
		$transaction->addChild('amount', $this->getAmount());

		// A custom field can be used to pass over the merchant site transaction ID.
		$transaction->addChild(static::TRANSACTION_ID_PARAM, $this->getTransactionId());

		$transaction->addChild('curcode', $this->getCurrency());
		$transaction->addChild('description', $this->getDescription());

		if (!is_null($this->getMerchantSpecification1())) {
			$transaction->addChild('merchantspecific1', $this->getMerchantSpecification1());
		}

		if (!is_null($this->getMerchantSpecification2())) {
			$transaction->addChild('merchantspecific2', $this->getMerchantSpecification2());
		}

		if (!is_null($this->getMerchantSpecification3())) {
			$transaction->addChild('merchantspecific3', $this->getMerchantSpecification3());
		}

		if (!is_null($this->getMerchantSpecification4())) {
			$transaction->addChild('merchantspecific4', $this->getMerchantSpecification4());
		}

		if (!is_null($this->getMerchantSpecification5())) {
			$transaction->addChild('merchantspecific5', $this->getMerchantSpecification5());
		}

		$customer   = $data->addChild('customer');
		$creditCard = $data->addChild('creditcard');

		if ($card = $this->getCard()) {
			// customer billing details
			$customer->addChild('firstname', $this->getFirstname());
			$customer->addChild('lastname', $this->getLastname());
			$day = !is_null($this->getBirthDay());

			if ($day) {
				$customer->addChild('birthday', $this->getBirthDay());
			}

			$month = !is_null($this->getBirthMonth());

			if ($month) {
				$customer->addChild('birthmonth', $this->getBirthMonth());
			}

			$year = !is_null($this->getBirthYear());

			if ($year) {
				$customer->addChild('birthyear', $this->getBirthYear());
			}

			$customer->addChild('email', $card->getEmail() ?: $this->getEmail());

			$customer->addChild('countryiso', $card->getCountry());
			$state = !is_null($card->getState());

			if ($state) {
				$customer->addChild('stateregioniso', $card->getState());
			}

			$zip = !is_null($card->getPostcode());

			if ($zip) {
				$customer->addChild('zippostal', $card->getPostcode());
			}

			$customer->addChild('city', $card->getCity());

			$add1 = !is_null($card->getBillingAddress1());

			if ($add1) {
				$customer->addChild('address1', $card->getBillingAddress1());
			}

			$add2 = !is_null($card->getBillingAddress2());

			if ($add2) {
				$customer->addChild('address2', $card->getBillingAddress2());
			}

			$phone = !is_null($card->getBillingPhone());

			if ($phone) {
				$customer->addChild('phone1phone', $card->getBillingPhone());
			}

			$account = !is_null($this->getAccountId());

			if ($account) {
				$customer->addChild('accountid', $this->getAccountId());
			}

			$customer->addChild('ipaddress', $this->getClientIp());

			$creditCard->addChild('ccnumber', $card->getNumber());
			$creditCard->addChild('cccvv', $card->getCvv());
			$creditCard->addChild('expmonth', $card->getExpiryMonth());
			$creditCard->addChild('expyear', $card->getExpiryYear());
			$creditCard->addChild('nameoncard', $card->getName());

			$bcountry = !is_null($card->getShippingCountry());

			if ($bcountry) {
				$creditCard->addChild('billingcountryiso', $card->getShippingCountry());
			}

			$bstate = !is_null($card->getShippingState());

			if ($bstate) {
				$creditCard->addChild('billingstateregioniso', $card->getShippingState());
			}

			$bpcode = !is_null($card->getShippingPostcode());

			if ($bpcode) {
				$creditCard->addChild('billingzippostal', $card->getShippingPostcode());
			}

			$bcity = !is_null($card->getShippingCity());

			if ($bcity) {
				$creditCard->addChild('billingcity', $card->getShippingCity());
			}

			$badd1 = !is_null($card->getShippingAddress1());

			if ($badd1) {
				$creditCard->addChild('billingaddress1', $card->getShippingAddress1());
			}

			$badd2 = !is_null($card->getShippingAddress2());

			if ($badd2) {
				$creditCard->addChild('billingaddress2', $card->getShippingAddress2());
			}

			$bphone = !is_null($card->getShippingPhone());

			if ($bphone) {
				$creditCard->addChild('billingphone1phone', $card->getShippingPhone());
			}
		}

		if (!is_null($this->getRebillAmount()) || (!is_null($this->isRebill()) && $this->isRebill())) {
			$rebill = $data->addChild('rebill');

			if (!is_null($this->getRebillFrequency())) {
				$rebill->addChild('freq', $this->getRebillFrequency());
			}

			if (!is_null($this->getRebillStart())) {
				$rebill->addChild('start', $this->getRebillStart());
			}

			if (!is_null($this->getRebillAmount())) {
				$rebill->addChild('amount', $this->getRebillAmount());
			}

			if (!is_null($this->getRebillDescription())) {
				$rebill->addChild('desc', $this->getRebillDescription());
			}

			if (!is_null($this->getRebillCount())) {
				$rebill->addChild('count', $this->getRebillCount());
			}

			if (!is_null($this->getRebillFollowupTime())) {
				$rebill->addChild('followup_time', $this->getRebillFollowupTime());
			}

			if (!is_null($this->getRebillFollowupAmount())) {
				$rebill->addChild('followup_amount', $this->getRebillFollowupAmount());
			}
		}

		if (!empty($this->getInstallmentCount())) {
			$installment = $data->addChild('installments');
			$installment->addChild('count', $this->getInstallmentCount());

			if (!empty($this->getGracePeriod())) {
				$installment->addChild('graceperiod', $this->getGracePeriod());
			}

			if (!empty($this->getFilterValue())) {
				$installment->addChild('filtervalue', $this->getFilterValue());
			}
		}

		$auth = $data->addChild('auth');
		$auth->addChild('type', $this->getAuthType());

		if (!is_null($this->getSessionId())) {
			$auth->addChild('sessionid', $this->getSessionId());
		}

		if (!is_null($this->getAuthSid())) {
			$auth->addChild('sid', $this->getAuthSid());
		}

		return $data;
	}
}
