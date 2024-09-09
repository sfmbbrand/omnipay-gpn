<?php /** @noinspection PhpUnused */

/**
 * Copyright 2018 The GPN Authors. All rights reserved.
 * Use of this source code is governed by a MIT
 * license that can be found in the LICENSE file.
 *
 */

namespace Omnipay\GPNDataEurope\Message;

use Exception;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Client;
use Omnipay\Common\Message\AbstractRequest;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Request;

class PurchaseAuthorize extends AbstractRequest
{

    const DEV_MODE = 'DEV';
    const PROD_MODE = 'PROD';
    const TEST_MODE = 'TEST';
    const TEST_URL = 'https://txtest.txpmnts.com/api/transaction/';
    const TRANSACTION_ID_PARAM = 'merchanttransid';

    public int $cmd = 700;
    protected int $action;

    /**
     * @return string
     */
    public function getAccountId(): ?string
    {
        return $this->getParameter('accountId');
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getParameter('action');
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @return string
     */
    public function getApiPassword(): string
    {
        return $this->getParameter('apiPassword');
    }

    public function getApiUser(): string
    {
        return $this->getParameter('apiUser');
    }

    public function getAuthSid(): ?string
    {
        return $this->getParameter('authSid');
    }

    public function getAuthType(): string
    {
        return $this->getParameter('authType') ?: 'Direct';
    }

    public function getBirthDay(): ?string
    {
        return $this->getParameter('birthday');
    }

    /**
     * @return string
     */
    public function getBirthMonth(): ?string
    {
        return $this->getParameter('birthMonth');
    }

    /**
     * @return string
     */
    public function getBirthYear(): ?string
    {
        return $this->getParameter('birthYear');
    }

    /**
     * @return string
     * @throws InvalidRequestException
     */
    public function getCheckSum(): string
    {
        return sha1($this->getApiUser() . $this->getApiPassword() . $this->cmd . $this->getTransactionId() .
            $this->getAmount() . $this->getCurrency() . $this->getCard()->getNumber() . $this->getCard()->getCvv() . $this->getCard()->getName() .
            $this->getApiKey());
    }

    /**
     * @return string
     */
    public function getDEV(): string
    {
        return $this->getParameter('DEV');
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return SimpleXMLElement
     * @throws InvalidRequestException
     */
    public function getData(): SimpleXMLElement
    {
        return $this->getBillingData();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getParameter('email');
    }

    /**
     * @return string
     */
    public function getFilterValue(): string
    {
        return $this->getParameter('filterValue');
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->getParameter('firstname');
    }

    public function getFrom(): ?string
    {
        return $this->getParameter('from');
    }

    public function getGracePeriod(): int
    {
        return $this->getParameter('gracePeriod');
    }

    public function getInstallmentCount(): ?int
    {
        return $this->getParameter('installmentCount');
    }

    public function getLastname(): ?string
    {
        return $this->getParameter('lastname');
    }

    public function getMerchantSpecification1(): ?string
    {
        return $this->getParameter('merchantSpecification1');
    }

    public function getMerchantSpecification2(): ?string
    {
        return $this->getParameter('merchantSpecification2');
    }

    public function getMerchantSpecification3(): ?string
    {
        return $this->getParameter('merchantSpecification3');
    }

    public function getMerchantSpecification4(): ?string
    {
        return $this->getParameter('merchantSpecification4');
    }

    public function getMerchantSpecification5(): ?string
    {
        return $this->getParameter('merchantSpecification5');
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->getParameter('mode');
    }

    /**
     * @return string
     */
    public function getPROD(): string
    {
        return $this->getParameter('PROD');
    }

    public function getRebillAmount(): ?float
    {
        return $this->getParameter('rebillAmount');
    }

    public function getRebillCount(): int
    {
        return $this->getParameter('rebillCount');
    }

    public function getRebillDescription(): string
    {
        return $this->getParameter('rebillDescription');
    }

    public function getRebillFollowupAmount()
    {
        return $this->getParameter('rebillFollowupAmount');
    }

    public function getRebillFollowupTime(): string
    {
        return $this->getParameter('rebillFollowupTime');
    }

    public function getRebillFrequency(): ?string
    {
        return $this->getParameter('rebillFrequency');
    }

    public function getRebillStart(): ?string
    {
        return $this->getParameter('rebillStart');
    }

    public function getSessionId(): ?string
    {
        return $this->getParameter('sessionId');
    }

    public function getStatement(): string
    {
        return $this->getParameter('statement');
    }

    public function getTEST(): string
    {
        return $this->getParameter('TEST');
    }

    public function getURL(): string
    {
        return $this->getParameter($this->getMode());
    }

    public function isRebill(): ?string
    {
        return $this->getParameter('rebill');
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return Response
     * @throws InvalidResponseException
     * @throws Exception
     */
    public function sendData($data): Response
    {
        $headers = ['Content-Type' => 'application/xml; charset=utf-8'];
        $httpResponse = $this->httpClient->request('POST', $this->getURL(), $headers, $data->asXML());
        $content = new SimpleXMLElement($httpResponse->getBody()->getContents());

        return $this->response = new Response($this, $content);
    }

    public function setAccountId(string $accountId): void
    {
        $this->setParameter('accountId', $accountId);
    }

    public function setAction($action): void
    {
        $this->setParameter('action', intval($action));
    }

    public function setApiKey(string $apiKey): void
    {
        $this->setParameter('apiKey', $apiKey);
    }

    public function setApiPassword(string $apiPassword): void
    {
        $this->setParameter('apiPassword', $apiPassword);
    }

    public function setApiUser(string $apiUser): void
    {
        $this->setParameter('apiUser', $apiUser);
    }

    public function setAuthSid(string $authSid): void
    {
        $this->setParameter('authSid', $authSid);
    }

    public function setAuthType(string $authType = 'Direct'): void
    {
        $this->setParameter('authType', $authType);
    }

    public function setBirthDay(string $birthday): void
    {
        $this->setParameter('birthday', $birthday);
    }

    public function setBirthMonth(string $birthMonth): void
    {
        $this->setParameter('birthMonth', $birthMonth);
    }

    public function setBirthYear(string $birthYear): void
    {
        $this->setParameter('birthYear', $birthYear);
    }

    public function setDEV(string $url = self::TEST_URL): void
    {
        $this->setParameter(static::DEV_MODE, $url);
    }

    public function setEmail(string $email): void
    {
        $this->setParameter('email', $email);
    }

    public function setFilterValue(string $value): void
    {
        $this->setParameter('filterValue', $value);
    }

    public function setFirstname(string $firstname): void
    {
        $this->setParameter('firstname', $firstname);
    }

    public function setFrom(string $from): void
    {
        $this->setParameter('from', $from);
    }

    public function setGracePeriod(int $value): void
    {
        $this->setParameter('gracePeriod', $value);
    }

    public function setInstallmentCount(int $count): void
    {
        $this->setParameter('installmentCount', $count);
    }

    public function setLastname(string $lastname): void
    {
        $this->setParameter('lastname', $lastname);
    }

    public function setMerchantSpecification1(string $merchantSpecification1): void
    {
        $this->setParameter('merchantSpecification1', $merchantSpecification1);
    }

    public function setMerchantSpecification2(string $merchantSpecification2): void
    {
        $this->setParameter('merchantSpecification2', $merchantSpecification2);
    }

    public function setMerchantSpecification3(string $merchantSpecification3): void
    {
        $this->setParameter('merchantSpecification3', $merchantSpecification3);
    }

    public function setMerchantSpecification4(string $merchantSpecification4): void
    {
        $this->setParameter('merchantSpecification4', $merchantSpecification4);
    }

    public function setMerchantSpecification5(string $merchantSpecification5): void
    {
        $this->setParameter('merchantSpecification5', $merchantSpecification5);
    }

    public function setMode(string $mode): void
    {
        $this->setParameter('mode', $mode);
    }

    public function setPROD(string $url = self::TEST_URL): void
    {
        $this->setParameter(static::PROD_MODE, $url);
    }

    public function setRebill(string $rebill): void
    {
        $this->setParameter('rebill', $rebill);
    }

    public function setRebillAmount(?float $rebillAmount): void
    {
        $this->setParameter('rebillAmount', $rebillAmount);
    }

    public function setRebillCount(int $rebillCount): void
    {
        $this->setParameter('rebillCount', $rebillCount);
    }

    public function setRebillDescription(string $rebillDescription): void
    {
        $this->setParameter('rebillDescription', $rebillDescription);
    }

    public function setRebillFollowupAmount(string $rebillFollowupAmount): void
    {
        $this->setParameter('rebillFollowupAmount', $rebillFollowupAmount);
    }

    public function setRebillFollowupTime(string $rebillFollowupTime): void
    {
        $this->setParameter('rebillFollowupTime', $rebillFollowupTime);
    }

    public function setRebillFrecuency(string $rebillFrequency): void
    {
        $this->setParameter('rebillFrequency', $rebillFrequency);
    }

    public function setRebillStart(string $rebillStart): void
    {
        $this->setParameter('rebillStart', $rebillStart);
    }


    public function setSessionId(string $sessionId): void
    {
        $this->setParameter('sessionId', $sessionId);
    }

    public function setStatement(string $statement): void
    {
        $this->setParameter('statement', $statement);
    }

    public function setTEST(string $url = self::TEST_URL): void
    {
        $this->setParameter(static::TEST_MODE, $url);
    }

    /**
     * @return SimpleXMLElement
     * @throws InvalidRequestException
     */
    protected function getBaseData(): SimpleXMLElement
    {
        $data = new SimpleXMLElement('<transaction/>');

        if ($this->getFrom()) {
            if ($this->getFrom() === 'paymentpage') {
                $data = new SimpleXMLElement('<request/>');
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
     * @return SimpleXMLElement
     * @throws InvalidRequestException
     */
    protected function getBillingData(): SimpleXMLElement
    {
        $data = $this->getBaseData();
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

        $customer = $data->addChild('customer');
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

            $returnUrl = $card->getReturnUrl();
//vdp($returnUrl);
            if ($returnUrl) {
                $creditCard->addChild('returnurl', $returnUrl);
            }
        }
//        $data->addChild('notificationsurl', 'https://dev2-privada.oje.pt/pay-cb/converge-gate');

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
