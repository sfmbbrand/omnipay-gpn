<?php
/**
 * Created by PhpStorm.
 * User: rolando
 * Date: 10/12/15
 * Time: 1:03 PM
 */

namespace Omnipay\GPNDataEurope\Test;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\GPNDataEurope\GPNGateway;

class GPNGatewayTest extends GatewayTestCase {
	/**
	 * @var $voidOptions
	 */
	protected $voidOptions;

	/**
	 * @var $captureOptions
	 */
	private $captureOptions;

	/**
	 * @var $customers
	 */
	private $customers;

	/**
	 * @return array
	 */
	public function authorizeDataProvider() {
		$authorizeData = [];

		for ($i = 0; $i < 100; $i++) {
			$transId = rand(1000000000, 9999999999);

			$authorizeData['transactions'][$transId] = [
				'amount'        => '10.00',
				'card'          => $this->getValidCard(),
				'currency'      => 'USD',
				'transactionId' => $transId,
				'statement'     => 'Test Omnipay transaction',
				'description'   => 'Test Omnipay transaction',
				'birthDay'      => 16,
				'birthMonth'    => 7,
				'birthYear'     => 1985,
				'email'         => 'test@test.com',
				'clientIp'      => '127.0.0.0',
				'accountId'     => 12345,
				'authType'      => 'Auth',
			];
			$this->captureOptions[] = [
				'amount'      => $authorizeData['transactions'][$transId]['amount'],
				'gatetransid' => $transId,
			];
		}

		return $authorizeData;
	}

	/**
	 * @return mixed
	 */
	public function captureDataProvider() {
		return $this->captureOptions;
	}

	/**
	 * Helper method used by gateway test classes to generate a valid test credit card
	 */
	public function getValidCard() {
		$this->customers = [
			'firstname' => [
				'Sofia',
				'Annamarie',
				'Meta',
				'Louisa',
				'Lien',
				'Shonta',
				'Annamae',
				'Bobbi',
				'Ellyn',
				'Arnita',
				'Meagan',
				'Lilliana',
				'Anjelica',
				'Kenyatta',
				'Herminia',
				'Von',
				'Claudette',
				'Elenore',
				'Kandice',
				'Emeline',
				'Irma',
				'Hortencia',
				'Velma',
				'Erica',
				'Anabel',
				'Jamison',
				'Kimbra',
				'Jeffry',
				'Herbert',
				'Kasandra',
				'Grayce',
				'Libbie',
				'Fernande',
				'Jake',
				'Neely',
				'Arie',
				'Angie',
				'Hue',
				'Melvina',
				'Thresa',
				'Otto',
				'Louise',
				'Margarita',
				'Alexandria',
				'Elnora',
				'Socorro',
				'Katelynn',
				'Dillon',
				'Micaela',
				'Tressa',
			],
			'lastname'  => [
				'Chapdelaine',
				'Argueta',
				'Lauderdale',
				'Lawry',
				'Dressler',
				'Elsass',
				'Kesselman',
				'Shindler',
				'Dewalt',
				'Swope',
				'Steinfeldt',
				'Tolleson',
				'Calico',
				'Moro',
				'Kantor',
				'Winford',
				'Esch',
				'Zeman',
				'Wohl',
				'Berberich',
				'Schlegel',
				'Meade',
				'Wiggs',
				'Merrihew',
				'Schuller',
				'Burrus',
				'Askins',
				'Urbina',
				'Dallman',
				'Nowack',
				'Geers',
				'Buhl',
				'Pegues',
				'Graffam',
				'Klein',
				'Devito',
				'Cudney',
				'Leard',
				'Apicella',
				'Goods',
				'Bundy',
				'Swank',
				'Alvarenga',
				'Wenthold',
				'Arocho',
				'Parekh',
				'Hord',
				'Parkison',
				'Perea',
				'Otwell',
			],
		];

		$cards = [
			'success' => [
				'4242424242424242',
				'4012888888881881',
				'4000056655665556',
				'5555555555554444',
				'5200828282828210',
				'5105105105105100',
				'378282246310005',
				'371449635398431',
				'6011111111111117',
				'6011000990139424',
				'30569309025904',
				'38520000023237',
				'3530111333300000',
				'3566002020360505',
			],
		];

		$card = [
			'firstName'        => $this->customers['firstname'][rand(0, count($this->customers['firstname']) - 1)],
			'lastName'         => $this->customers['lastname'][rand(0, count($this->customers['lastname']) - 1)],
			'number'           => trim($cards['success'][rand(0, count($cards['success']) - 1)]),
			'expiryMonth'      => rand(1, 12),
			'expiryYear'       => gmdate('Y') + rand(1, 5),
			'cvv'              => trim(rand(100, 500)),
			'billingAddress1'  => '123 Billing St',
			'billingAddress2'  => 'Billsville',
			'billingCity'      => 'Billstown',
			'billingPostcode'  => '12345',
			'billingState'     => 'CAL',
			'billingCountry'   => 'USA',
			'billingPhone'     => '18888888888',
			'shippingAddress1' => '123 Shipping St',
			'shippingAddress2' => 'Shipsville',
			'shippingCity'     => 'Shipstown',
			'shippingPostcode' => '54321',
			'shippingState'    => 'NY',
			'shippingCountry'  => 'USA',
			'shippingPhone'    => '18888888888',
		];

		return $card;
	}

	/**
	 * @return array
	 */
	public function purchaseDataProvider() {
		$purchaseData = [];

		for ($i = 0; $i < 100; $i++) {
			$transId = rand(1000000000, 9999999999);

			$purchaseData['transactions'][$transId] = [
				'amount'        => '10.00',
				'card'          => $this->getValidCard(),
				'currency'      => 'USD',
				'transactionId' => $transId,
				'statement'     => 'Test Omnipay transaction',
				'description'   => 'Test Omnipay transaction',
				'birthDay'      => 16,
				'birthMonth'    => 7,
				'birthYear'     => 1985,
				'email'         => 'test@test.com',
				'clientIp'      => '127.0.0.0',
				'accountId'     => 12345,
			];
		}

		return $purchaseData;
	}

	/**
	 * @dataProvider authorizeDataProvider
	 */
	public function testAuthorizeSuccess($authorizeOptions) {
		$responseAuth = $this->gateway->authorize($authorizeOptions)->send();
		$this->assertFalse($responseAuth->isSuccessful());
		$this->assertEquals('000', $responseAuth->getCode());
		$this->assertEquals('This transaction has been capture.', $responseAuth->getMessage());
	}

	/**
	 * @dataProvider captureDataProvider
	 */
	public function testCaptureSuccess($captureOptions) {
		$responseCapture = $this->gateway->capture($captureOptions);
		$this->assertFalse($responseCapture->isSuccessful());
		$this->assertEquals('000', $responseCapture->getCode());
		$this->assertEquals('', $responseCapture->getMessage());
	}

	/**
	 * @dataProvider purchaseDataProvider
	 */
	public function testPurchaseSuccess($purchaseOptions) {
		$response = $this->gateway->purchase($purchaseOptions)->send();
		$this->assertFalse($response->isSuccessful());

		$this->assertEquals('000', $response->getCode());
		$this->assertEquals('This transaction has been approved.', $response->getMessage());
	}

	/**
	 *
	 */
	protected function setUp() {
		parent::setUp();
		$this->getHttpClient()->setDefaultOption('verify', false);
		$this->gateway = new GPNGateway($this->getHttpClient(), $this->getHttpRequest());
		$this->gateway->setApiUser('rolando');
		$this->gateway->setApiPassword('8a6a2029c94a');
		$this->gateway->setApiKey('F2AB5662-A6FC-E359-F122-2F6FF2BAA879');
	}
}
