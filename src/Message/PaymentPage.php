<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Message;

use Exception;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\Client;
use Omnipay\Common\Message\ResponseInterface;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Request;

class PaymentPage extends PurchaseAuthorize {
	const PPAGE_MODE = 'PPAGE';

	const PPAGE_TEST_URL = 'https://ppt.txpmnts.com/payment-init';

	/**
	 * PaymentPage constructor.
	 *
	 * @param Client $httpClient
	 * @param Request $httpRequest
	 */
	public function __construct(Client $httpClient, Request $httpRequest) {
		parent::__construct($httpClient, $httpRequest);
		$this->cmd = 710;
	}

    public function getAddress1(): string
    {
		return $this->getParameter('address1');
	}

    public function getAddress2(): string
    {
		return $this->getParameter('address2');
	}

    public function getAuth(): string
    {
		return $this->getParameter('auth');
	}

	/**
	 * @return string
     * @throws InvalidRequestException
     */
	public function getCheckSum(): string
    {
		return sha1($this->getApiUser() .
			$this->getApiPassword() .
            $this->cmd .
			$this->getMerchantTransactionId() .
            $this->getAmount() .
			$this->getCurrency() .
			$this->getApiKey()
		);
	}

	/**
	 * @return string
	 */
	public function getCity() {
		return $this->getParameter('city');
	}

	/**
	 * @return string
	 */
	public function getContactUrl() {
		return $this->getParameter('contact_url');
	}

	/**
	 * @return string
	 */
	public function getCountry() {
		return $this->getParameter('country');
	}

	/**
	 * @return string
	 */
	public function getCustomerReturn() {
		return $this->getParameter('customer_return');
	}

	/**
	 * @return string
	 */
	public function getLogo() {
		return $this->getParameter('logourl');
	}

	/**
	 * @return string
	 */
	public function getMerchantTransactionId() {
		return $this->getParameter('merchant_transaction_id');
	}

	/**
	 * @return string
	 */
	public function getMerchantname() {
		return $this->getParameter('merchantname');
	}

	/**
	 * @return string
	 */
	public function getPPAGE() {
		return $this->getParameter('PPAGE');
	}

	/**
	 * @return string
	 */
	public function getPhone() {
		return $this->getParameter('phone');
	}

	/**
	 * @return array
	 */
	public function getProducts() {
		return $this->getParameter('products');
	}

	/**
	 * @return string
	 */
	public function getState() {
		return $this->getParameter('state');
	}

    public function getStatement(): string
    {
		return $this->getParameter('statement');
	}

    public function getZip(): string
    {
		return $this->getParameter('zip');
	}

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws Exception
     */
	public function sendData($data): Response
    {
		$headers               = ['Content-Type' => 'application/x-www-form-urlencoded'];
		$httpResponse          = $this->httpClient->request('POST', $this->getPPAGE(), $headers, ['strrequest' => $data->asXML()]);
		$content               = new SimpleXMLElement($httpResponse->getBody()->getContents());
		return $this->response = new Response($this, $content);
	}

    public function setAddress1(string $address1): void
    {
		$this->setParameter('address1', $address1);
	}

    public function setAddress2(string $address2) {
		$this->setParameter('address2', $address2);
	}

    public function setAuth(string $auth) {
		$this->setParameter('auth', $auth);
	}

    public function setCity(string $city) {
		$this->setParameter('city', $city);
	}

    public function setContactUrl(string $contactUrl) {
		$this->setParameter('contact_url', $contactUrl);
	}

	/**
	 * @param string $country
	 */
	public function setCountry($country) {
		$this->setParameter('country', $country);
	}

	/**
	 * @param string $customerReturn
	 */
	public function setCustomerReturn($customerReturn) {
		$this->setParameter('customer_return', $customerReturn);
	}

	/**
	 * @param string $logo
	 */
	public function setLogo($logo) {
		$this->setParameter('logourl', $logo);
	}

	/**
	 * @param string $MerchantTransactionId
	 */
	public function setMerchantTransactionId($MerchantTransactionId) {
		$this->setParameter('merchant_transaction_id', $MerchantTransactionId);
	}

	/**
	 * @param string $merchantname
	 */
	public function setMerchantname($merchantname) {
		$this->setParameter('merchantname', $merchantname);
	}

	/**
	 * @param string $url
	 */
	public function setPPAGE($url = self::PPAGE_TEST_URL) {
		$this->setParameter(static::PPAGE_MODE, $url);
	}

	/**
	 * @param string $phone
	 */
	public function setPhone($phone) {
		$this->setParameter('phone', $phone);
	}

	/**
	 * @param array $products
	 */
	public function setProducts($products) {
		$this->setParameter('products', $products);
	}

	/**
	 * @param string $state
	 */
	public function setState($state) {
		$this->setParameter('state', $state);
	}

    public function setStatement(string $statement): void
    {
		$this->setStatement('statement', $statement);
	}

    public function setZip(string $zip): void
    {
		$this->setParameter('zip', $zip);
	}

	/**
	 * @return SimpleXMLElement
	 */
	protected function getBaseData(): SimpleXMLElement
    {
		$data = new SimpleXMLElement('<transaction/>');

		if ($this->getFrom()) {
			if ($this->getFrom() === 'paymentpage') {
				$data = new \SimpleXMLElement('<request/>');
			}

			$data->addAttribute('from', $this->getFrom());
		}

		$data->addChild('apiUser', $this->getApiUser());
		$data->addChild('apiPassword', $this->getApiPassword());
		$data->addChild('apiCmd', $this->cmd);

		return $data;
	}

	/**
	 * @return SimpleXMLElement
	 * @throws InvalidRequestException
	 */
	protected function getBillingData(): SimpleXMLElement
    {
		$data = $this->getBaseData();
		$data->addChild('customerreturn', $this->getCustomerReturn());
		$data->addChild('contacturl', $this->getContactUrl());
		$data->addChild('merchantname', $this->getMerchantname());

		if ($logo = $this->getLogo()) {
			$data->addChild('logourl', $logo);
		}

		$transaction = $data->addChild('transaction');
		$transaction->addChild(static::TRANSACTION_ID_PARAM, $this->getTransactionId());
		$transaction->addChild('amount', $this->getAmount());
		$transaction->addChild('curcode', $this->getCurrency());
		$transaction->addChild('description', $this->getDescription());

		if ($statement = $this->getStatement()) {
			$transaction->addChild('statement', $statement);
		}

		$customer = $data->addChild('customer');
		$customer->addChild('firstname', $this->getFirstName());
		$customer->addChild('lastname', $this->getLastName());
		$customer->addChild('email', $this->getEmail());

		if ($country = $this->getCountry()) {
			$customer->addChild('countryiso', $this->getCountry());
		}

		if ($state = $this->getState()) {
			$customer->addChild('stateregioniso', $state);
		}

		if ($zip = $this->getZip()) {
			$customer->addChild('zippostal', $this->getZip());
		}

		if ($city = $this->getCity()) {
			$customer->addChild('city', $city);
		}

		if ($add1 = $this->getAddress1()) {
			$customer->addChild('address1', $add1);
		}

		if ($add2 = $this->getAddress2()) {
			$customer->addChild('address2', $add2);
		}

		if ($phone = $this->getPhone()) {
			$customer->addChild('phone1phone', $phone);
		}

		if ($account = $this->getAccountId()) {
			$customer->addChild('accountid', $account);
		}

		$customer->addChild('ipaddress', $this->getClientIp());

		$products = $this->getProducts();

		if (is_array($products)) {
			$prod = $data->addChild('products');

			foreach ($products as $value) {
				$product = $prod->addChild('product');
				$product->addChild('name', $value['name']);
				$product->addChild('description', $value['description']);
				$product->addChild('price', $value['price']);
				$product->addChild('amount', $value['amount']);
			}
		}

		$data->addChild('checksum', $this->getCheckSum());
		$auth = $data->addChild('auth');
		$auth->addChild('type', $this->getAuth());

		return $data;
	}
}
