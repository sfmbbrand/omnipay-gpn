<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Response;

/**
 * Class Rebill
 *
 * @description Manipulative class of rebill data
 *
 * @package Omnipay\GPNDataEurope\Response
 */
class Rebill {
	/**
	 * Rebill secret sent by gateway merchant.
	 * This parameter should be store in the merchant side in order to use it in rebill manual
	 *
	 * @var string $secret
	 */
	private $secret;

	/**
	 * Rebill window sent by the gateway to merchant
	 *
	 * @var string $window
	 */
	private $window;

	/**
	 * @return mixed
	 */
	public function getSecret() {
		return $this->secret;
	}

	/**
	 * @return mixed
	 */
	public function getWindow() {
		return $this->window;
	}

	/**
	 * @param mixed $secret
	 *
	 * @return $this
	 */
	public function setSecret($secret) {
		$this->secret = $secret;
		return $this;
	}

	/**
	 * @param mixed $window
	 *
	 * @return $this
	 */
	public function setWindow($window) {
		$this->window = $window;
		return $this;
	}
}
