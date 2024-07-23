<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Response;

/**
 * Manipulative class of omnipay response data
 *
 * @package Omnipay\GPNDataEurope\Response
 */
class Data {
	/**
	 * Response success process
	 * @var boolean
	 */
	private $isSuccess;

	/**
	 * Response merchant transaction id
	 * @var string
	 */
	private $merchantTransId;

	/**
	 * Response message
	 * @var string
	 */
	private $message;

	/**
	 * Response rebill parameters
	 * @var \Omnipay\GPNDataEurope\Response\Rebill
	 */
	private $rebill;

	/**
	 * Response redirect url
	 * @var string
	 */
	private $redirectUrl;

	/**
	 * Response transaction reference
	 * @var string
	 */
	private $refer;

	/**
	 * Response 3d secure transaction data
	 * @var \Omnipay\GPNDataEurope\Response\Secure
	 */
	private $secure;

	/**
	 * Response status
	 * @var string
	 */
	private $status;

	/**
	 * Response Status code
	 * @var string
	 */
	private $statusCode;

	/**
	 * Response transaction id
	 * @var string
	 */
	private $transId;

    private $transaction;

	/**
	 * Get transaction id in merchant side
	 *
	 * @return string
	 */
	public function getMerchantTransId() {
		return $this->merchantTransId;
	}

	/**
	 * Get message
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Get rebill parameters
	 *
	 * @return \Omnipay\GPNDataEurope\Response\Rebill
	 */
	public function getRebill() {
		return $this->rebill;
	}

	/**
	 * Get redirect url return in the response
	 *
	 * @return string
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}

	/**
	 * Get reference of the transaction
	 *
	 * @return string
	 */
	public function getRefer() {
		return $this->refer;
	}

	/**
	 * Get 3d secure transaction parameters
	 *
	 * @return \Omnipay\GPNDataEurope\Response\Secure
	 */
	public function getSecure() {
		return $this->secure;
	}

	/**
	 * Get response status
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Get the status code of the response
	 *
	 * @return string
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * Get transaction id return in the response
	 *
	 * @return string
	 */
	public function getTransId() {
		return $this->transId;
	}

    public function getTransaction() {
        return $this->transaction;
    }

    public function setTransaction($transaction) {
        foreach ((array)$transaction as $key => $value) {
            $this->transaction[$key] = (string)$value;
        }

        return $this->transaction;
    }

	/**
	 * Get if the process was successful finished
	 *
	 * @return boolean
	 */
	public function isSuccess() {
		return $this->isSuccess;
	}

	/**
	 * Set process status
	 *
	 * @param boolean $isSuccess
	 *
	 * @return $this
	 */
	public function setIsSuccess($isSuccess) {
		$this->isSuccess = $isSuccess;
		return $this;
	}

	/**
	 * Set transaction id in merchant side
	 *
	 * @param string $merchantTransId
	 *
	 * @return $this
	 */
	public function setMerchantTransId($merchantTransId) {
		$this->merchantTransId = $merchantTransId;
		return $this;
	}

	/**
	 * Set Message data
	 *
	 * @param string $message
	 *
	 * @return $this
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

	/**
	 * Set Rebill parameters
	 *
	 * @param \Omnipay\GPNDataEurope\Response\Rebill $rebill
	 *
	 * @return $this
	 */
	public function setRebill($rebill) {
		$this->rebill = $rebill;
		return $this;
	}

	/**
	 * set redirect url return in the response
	 *
	 * @param string $redirectUrl
	 *
	 * @return $this
	 */
	public function setRedirectUrl($redirectUrl) {
		$this->redirectUrl = $redirectUrl;
		return $this;
	}

	/**
	 * Set reference transaction
	 *
	 * @param string $refer
	 *
	 * @return $this
	 */
	public function setRefer($refer) {
		$this->refer = $refer;
		return $this;
	}

	/**
	 * Set 3d secure transaction parameters
	 *
	 * @param string $secure
	 *
	 * @return $this
	 */
	public function setSecure($secure) {
		$this->secure = $secure;
		return $this;
	}

	/**
	 * Set response status
	 *
	 * @param string $status
	 *
	 * @return $this
	 */
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}

	/**
	 * Set the status code response
	 *
	 * @param mixed $statusCode
	 *
	 * @return $this
	 */
	public function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;
		return $this;
	}

	/**
	 * Set transaction id return in the response
	 *
	 * @param string $transId
	 *
	 * @return $this
	 */
	public function setTransId($transId) {
		$this->transId = $transId;
		return $this;
	}
}
