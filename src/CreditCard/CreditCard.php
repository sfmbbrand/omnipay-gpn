<?php
/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 */

namespace Omnipay\GPNDataEurope\CreditCard;

/**
 * Class CreditCard
 *
 * @package Omnipay\GPNDataEurope\CreditCard
 */
class CreditCard extends \Omnipay\Common\CreditCard {

    // test jj & sergi 16-7-24
    public function getReturnUrl() {
        return $this->getParameters('returnurl');
    }

    public function setReturnUrl($return_url) {
        $this->setParameter('returnurl', $return_url);
    }
    // end test

	/**
	 * @return array
	 */
	public function getIssueMonth() {
		return $this->getParameters('issuemonth');
	}

	/**
	 * @return array
	 */
	public function getIssueYear() {
		return $this->getParameters('issueyear');
	}

	/**
	 * @param $issuemonth
	 */
	public function setIssueMonth($issuemonth) {
		$this->setParameter('issuemonth', $issuemonth);
	}

	/**
	 * @param $issueyear
	 */
	public function setIssueYear($issueyear) {
		$this->setParameter('issueyear', $issueyear);
	}
}
