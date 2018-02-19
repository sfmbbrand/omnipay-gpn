<?php
/**
 * User: Rolando Toledo
 * Email: rtf@gpndata.com
 * Date: 4/5/17
 * Time: 2:10 PM
 *
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\Response;

/**
 * Class Secure
 *
 * @description Manipulative class of the 3d secure transaction data
 *
 * @package Omnipay\GPNDataEurope\Response
 */

class Secure {
	/**
	 * ACS server url
	 *
	 * @var string $acs
	 */
	private $acs;

	/**
	 * MD parameter md use in 3ds
	 *
	 * @var string $md
	 */
	private $md;

	/**
	 * PaReq parameter use in 3ds
	 *
	 * @var string $paReq
	 */
	private $paReq;

	/**
	 * TermUrl parameter termUrl use in 3ds
	 *
	 * @var string $termUrl
	 */
	private $termUrl;

	/**
	 * @return string
	 */
	public function getAcs() {
		return $this->acs;
	}

	/**
	 * @return string
	 */
	public function getMd() {
		return $this->md;
	}

	/**
	 * @return string
	 */
	public function getPaReq() {
		return $this->paReq;
	}

	/**
	 * @return string
	 */
	public function getTermUrl() {
		return $this->termUrl;
	}

	/**
	 * @param string $acs
	 *
	 * @return $this
	 */
	public function setAcs($acs) {
		$this->acs = $acs;
		return $this;
	}

	/**
	 * @param string $md
	 *
	 * @return $this
	 */
	public function setMd($md) {
		$this->md = $md;
		return $this;
	}

	/**
	 * @param string $paReq
	 *
	 * @return $this
	 */
	public function setPaReq($paReq) {
		$this->paReq = $paReq;
		return $this;
	}

	/**
	 * @param string $termUrl
	 *
	 * @return $this
	 */
	public function setTermUrl($termUrl) {
		$this->termUrl = $termUrl;
		return $this;
	}
}
