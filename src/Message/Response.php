<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Message;

use Omnipay\GPNDataEurope\Response\Data;
use Omnipay\GPNDataEurope\Response\Rebill;
use Omnipay\GPNDataEurope\Response\Secure;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Class Response
 *
 * @package Omnipay\GPNDataEurope\Message
 */
class Response extends AbstractResponse {
	const AUTHORIZED = 'AUTHORIZED';

	const CANCELED = 'CANCELED';

	const DECLINED = 'DECLINED';

	const ERROR = 'ERROR';

	const OK = 'OK';

	const PENDING = 'PENDING';

	const REQUEST_PENDING = 'RequestPending';

	const SUCCESS = 'SUCCESS';

	/**
	 * Api700Response constructor.
	 *
	 * @param RequestInterface $request
	 * @param mixed $data
	 */
	public function __construct(RequestInterface $request, $data) {
		$this->request = $request;
		$this->data    = new Data();

		if (!$data instanceof \SimpleXMLElement) {
			throw new InvalidResponseException();
		}

		$this->bindData($data);
	}

	/**
	 * Bind data in the Response data object
	 *
	 * @param $data
	 */
	public function bindData($data) {
		$secure  = new Secure();
		$message = !empty($data->errormessage) ? (string) $data->errormessage : (string) $data->description;
		$rebill  = new Rebill();
		$secure
			->setAcs((string) ($data->ACS ?: null))
			->setPaReq((string) ($data->parameters->PaReq ?: null))
			->setMd((string) ($data->parameters->MD ?: null))
			->setTermUrl((string) ($data->parameters->TermUrl ?: null));
		$rebill
			->setSecret((string) ($data->rebillsecret ?: null))
			->setWindow((string) $data->rebillwindows ?: null);
		$this->data
			->setIsSuccess(
				self::SUCCESS == $data->result ||
				self::AUTHORIZED == $data->result ||
				self::CANCELED == $data->result ||
				self::PENDING == $data->result ||
				self::OK == $data->result ||
				self::REQUEST_PENDING == $data->result
			)
			->setStatus((string) $data->result)
			->setStatusCode((string) $data->errorcode)
			->setMessage($message)
			->setRefer((integer) ($data->transref ?: null))
			->setTransId((string) ($data->gatetransid ?: null))
			->setMerchantTransId((string) ($data->merchanttransid ?: null))
			->setSecure($secure)
			->setRebill($rebill)
			->setRedirectUrl((string) ($data->customerurl ?: null));
	}

	/**
	 * Get the ACS server url
	 *
	 * @return string
	 */
	public function getACS() {
		return $this->data->getSecure()->getAcs();
	}

	/**
	 * Get the response status code
	 * @return string
	 */
	public function getCode() {
		return $this->data->getStatusCode();
	}

	/**
	 * Get redirect URL used after transaction finished
	 *
	 * @return string
	 */
	public function getCustomerUrl() {
		return $this->data->getRedirectUrl();
	}

	/**
	 * Get whole data response object
	 *
	 * @return Data
	 */
	public function getData() {
		return parent::getData();
	}

	/**
	 * Get the response description
	 * @deprecated This method should be remove en in the next version instead getDescription use getMessage
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->getMessage();
	}

	/**
	 * Get the transaction id
	 * @return string
	 */
	public function getGatewayTransactionId() {
		return $this->data->getTransId();
	}

	/**
	 * Get MD use in 3d secure transaction
	 *
	 * @return string
	 */
	public function getMD() {
		return $this->data->getSecure()->getMd();
	}

	/**
	 * Get transaction id in merchant side
	 *
	 * @return string
	 */
	public function getMerchantTransId() {
		return $this->data->getMerchantTransId();
	}

	/**
	 * Get the response message
	 * @return string
	 */
	public function getMessage() {
		return $this->data->getMessage();
	}

	/**
	 * Get PaReq use in 3d secure transaction
	 *
	 * @return string
	 */
	public function getPaReq() {
		return $this->data->getSecure()->getPaReq();
	}

	/**
	 * Get rebill secret returned in the recurring transaction request
	 *
	 * @return string
	 */
	public function getRebillSecret() {
		return $this->data->getRebill()->getSecret();
	}

	/**
	 * Get rebill windows
	 *
	 * @return \SimpleXMLElement | null
	 */
	public function getRebillWindows() {
		return $this->data->getRebill()->getWindow();
	}

	/**
	 * Get status code
	 *
	 * @return string
	 */
	public function getResult() {
		return $this->data->getStatus();
	}

	/**
	 * Get Term URL
	 *
	 * @return mixed
	 */
	public function getTermURL() {
		return $this->data->getSecure()->getTermUrl();
	}

	/**
	 * Get the transaction reference
	 *
	 * @return string
	 */
	public function getTransactionReference() {
		return $this->data->getRefer();
	}

	/**
	 * Return if the transaction was successful or not
	 *
	 * @return boolean
	 */
	public function isSuccessful() {
		return $this->data->isSuccess();
	}
}
