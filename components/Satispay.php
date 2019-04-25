<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-satispay
 * @license BSD-3-Clause
 * @package yii2-satispay
 * @version 0.1.0
 */

namespace cinghie\satispay\components;

use SatispayGBusiness\Api;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class Satispay
 *
 * @see https://developers.satispay.com/docs
 *
 * @property array $authenticationData
 * @property string $authenticationJSON
 */
class Satispay extends Component
{
	/**
	 * @var string
	 */
	public $authenticationPath;

	/**
	 * @var string sandbox | production
	 */
	public $endPoint;

	/**
	 * @var string
	 */
	public $token;

	/**
	 * @var string
	 */
	private $_keyId;

	/**
	 * @var string
	 */
	private $_privateKey;

	/**
	 * @var string
	 */
	private $_publicKey;

	/**
	 * Satispay constructor
	 *
	 * @param array $config
	 *
	 * @see https://github.com/satispay/gbusiness-api-php-sdk
	 * @throws InvalidConfigException
	 */
	public function __construct(array $config = [])
	{
		if(!$config['token']) {
			throw new InvalidConfigException(Yii::t('satispay', 'Satispay token missing!'));
		}

		$this->authenticationPath = $config['authenticationPath'] ?: '@webroot';
		$this->endPoint = $config['endPoint'] ?: 'sandbox';
		$this->token = $config['token'];

		parent::__construct($config);
	}

	/**
	 * Satispay init
	 */
	public function init()
	{
		if($this->endPoint === 'sandbox') {
			Api::setSandbox(true);
		}

		if (!file_exists($this->getAuthenticationJSON())) {

			$authData = Api::authenticateWithToken($this->token);

			$this->_keyId = $authData->keyId;
			$this->_privateKey = $authData->privateKey;
			$this->_publicKey = $authData->publicKey;

			$this->createAuthenticationJSON();

		} else {
			$authData = $this->getAuthenticationData();

			$this->_keyId = $authData->keyId;
			$this->_privateKey = $authData->privateKey;
			$this->_publicKey = $authData->publicKey;
		}
	}

	/**
	 * Create Autentication JSON
	 *
	 * @return string
	 */
	private function createAuthenticationJSON()
	{
		$authenticationFile = $this->authenticationPath.'/authentication.json';

		file_put_contents(Yii::getAlias($authenticationFile), json_encode([
			'key_id' => $this->_keyId,
			'private_key' => $this->_privateKey,
			'public_key' => $this->_publicKey,
		], JSON_PRETTY_PRINT));

		return $authenticationFile;
	}

	/**
	 * Get Autentication JSON
	 *
	 * @retun string
	 */
	private function getAuthenticationJSON()
	{
		return Yii::getAlias($this->authenticationPath.'/authentication.json');
	}

	/**
	 * Get Autentication Data
	 *
	 * @return array
	 */
	private function getAuthenticationData()
	{
		return json_decode(file_get_contents($this->getAuthenticationJSON()), true);
	}
}
