<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope;

use Omnipay\Common\AbstractGateway;
use Omnipay\GPNDataEurope\Message\Cancel;
use Omnipay\GPNDataEurope\Message\Credit;
use Omnipay\GPNDataEurope\Message\Capture;
use Omnipay\GPNDataEurope\Message\Complete;
use Omnipay\Common\Exception\RuntimeException;
use Omnipay\GPNDataEurope\Message\PurchaseAuthorize;
use Omnipay\GPNDataEurope\Message\Notification\Notification;
use Omnipay\GPNDataEurope\Message\Notification\DisputeNotification;

/**
 *
 * @method \Omnipay\Common\Message\ResponseInterface void(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\ResponseInterface deleteCard(array $options = [])
 */
class GPNGateway extends AbstractGateway {
	const DEV_MODE = 'DEV';

	const PPAGE_MODE = 'PPAGE';

	const PPAGE_URL = 'https://api.convergegate.com/api/transaction/';

	const PROD_MODE = 'PROD';

	const TEST_MODE = 'TEST';

	const TEST_URL = 'https://testdashboard.convergegate.com/api/transaction/';

	/**
	 * Get notification message to send notification to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function acceptNotification(array $parameters = []) {
		return $this->createRequest(Notification::class, $parameters);
	}

	/**
	 * Create authorization request use to send authorization to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function authorize(array $parameters = []) {
		return $this->createRequest(PurchaseAuthorize::class, $parameters);
	}

	/**
	 * Create capture request use to send capture to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function capture(array $parameters = []): Capture {
		return $this->createRequest(Capture::class, $parameters);
	}

	/**
	 * Cancel cancels a authorize transaction
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function cancel(array $parameters = []) {
		return $this->createRequest(Cancel::class, $parameters);
	}

	/**
	 * Get complete authorize request use to send capture authorize to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function completeAuthorize(array $parameters = []) {
		return $this->createRequest(Complete::class, $parameters);
	}

	/**
	 * Get complete purchase request use to send complete purchase to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function completePurchase(array $parameters = []) {
		return $this->completeAuthorize($parameters);
	}

	/**
	 * @param array $parameters
	 * @return mixed
	 */
	public function credit(array $parameters = []) {
		return $this->createRequest(Credit::class, $parameters);
	}

	/**
	 * Get dispute notification message to send dispute request to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function disputeNotification(array $parameters = []) {
		return $this->createRequest(DisputeNotification::class, $parameters);
	}

	/**
	 * Get merchant API Key
	 *
	 * @return string
	 */
	public function getApiKey() {
		return $this->getParameter('apiKey');
	}

	/**
	 * Get merchant API password
	 *
	 * @return string
	 */
	public function getApiPassword() {
		return $this->getParameter('apiPassword');
	}

	/**
	 * Return merchant API user
	 * @return string
	 */
	public function getApiUser() {
		return $this->getParameter('apiUser');
	}

	/**
	 * Get mode dev
	 *
	 * @return void
	 */
	public function getDEV() {
		return $this->getParameter('DEV');
	}

	/**
	 * Return default parameters use in the omnipay
	 *
	 * @return array
	 */
	public function getDefaultParameters() {
		return [
			'apiUser'          => '',
			'apiPassword'      => '',
			'apiKey'           => '',
			'mode'             => self::DEV_MODE,
			static::DEV_MODE   => self::TEST_URL,
			static::TEST_MODE  => self::TEST_URL,
			static::PROD_MODE  => self::TEST_URL,
			static::PPAGE_MODE => self::PPAGE_URL,
		];
	}

	/**
	 * Get mode set to send the transaction
	 *
	 * @return void
	 */
	public function getMode() {
		return $this->getParameter('mode');
	}

	/**
	 * Get gateway display name
	 *
	 * This can be used by carts to get the display name for each gateway.
	 *
	 * @return string
	 */
	public function getName() {
		return 'GPNData Europe';
	}

	/**
	 * Get Payment page mode
	 *
	 * @return string
	 */
	public function getPPAGE() {
		return $this->getParameter('PPAGE');
	}

	/**
	 * Get production mode
	 *
	 * @return string
	 */
	public function getPROD() {
		return $this->getParameter('PROD');
	}

	/**
	 * Get test mode
	 *
	 * @return void
	 */
	public function getTEST() {
		return $this->getParameter('TEST');
	}

	/**
	 * Get manual rebill message to send manual rebill to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function manualRebill(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\ManualRebill', $parameters);
	}

	/**
	 * Get payment page message to send request to the payment page
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function paymentPage(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\PaymentPage', $parameters);
	}

	/**
	 * Get purchase request use to send direct to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function purchase(array $parameters = []) {
		return $this->authorize($parameters);
	}

	/**
	 * Get rebill notification message to send refund notification to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function rebillNotification(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\Notification\RebillNotification', $parameters);
	}

	/**
	 * Get refund request use to send refund transaction to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function refund(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\RefundRequest', $parameters);
	}

	/**
	 * Get refund notification message to send refund notification to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function refundNotification(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\Notification\RefundNotification', $parameters);
	}

	/**
	 * Set merchant api key
	 *
	 * @param string $apiKey
	 * @return void
	 */
	public function setApiKey($apiKey) {
		$this->setParameter('apikey', $apiKey);
	}

	/**
	 * Set merchant API password
	 *
	 * @param string $apiPassword
	 * @return void
	 */
	public function setApiPassword($apiPassword) {
		$this->setParameter('apiPassword', $apiPassword);
	}

	/**
	 * Set merchant API user
	 *
	 * @param $apiUser
	 */
	public function setApiUser($apiUser) {
		$this->setParameter('apiUser', $apiUser);
	}

	/**
	 * Set mode to dev
	 *
	 * @param string $url
	 * @return void
	 */
	public function setDEV($url = self::TEST_URL) {
		$this->setParameter(static::DEV_MODE, $url);
	}

	/**
	 * @param $mode DEV|TEST|PROD|PPAGE
	 */
	public function setMode($mode = 'DEV', $verify = true) {
		if ($mode !== self::DEV_MODE &&
			$mode !== self::TEST_MODE &&
			$mode !== self::PROD_MODE &&
			$mode !== self::PPAGE_MODE) {
			throw new RuntimeException();
		}

		$this->setParameter('mode', $mode);
	}

	/**
	 * Set payment page mode
	 *
	 * @param string $url
	 * @return void
	 */
	public function setPPAGE($url = self::PPAGE_URL) {
		$this->setParameter(static::PPAGE_MODE, $url);
	}

	/**
	 * Set mode to production
	 *
	 * @param string $url
	 * @return void
	 */
	public function setPROD($url = self::TEST_URL) {
		$this->setParameter(static::PROD_MODE, $url);
	}

	/**
	 * Set mode to test
	 *
	 * @param string $url
	 * @return void
	 */
	public function setTEST($url = self::TEST_URL) {
		$this->setParameter(static::TEST_MODE, $url);
	}

	/**
	 * Get transaction status message to get status transaction to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function transactionStatus(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\Transaction', $parameters);
	}

	/**
	 * Get update rebill message to send rebill update to the gateway
	 *
	 * @param array $parameters
	 * @return void
	 */
	public function updateRebill(array $parameters = []) {
		return $this->createRequest('Omnipay\GPNDataEurope\Message\UpdateRebill', $parameters);
	}
}
